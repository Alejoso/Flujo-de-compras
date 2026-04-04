<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCotizacionRequest;
use App\Http\Requests\UpdateCotizacionRequest;
use App\Models\Cotizacion;
use App\Models\PresentacionTipoMaterialVersionCotizacion;
use App\Models\Proyecto;
use App\Models\TipoMaterial;
use App\Models\User;
use App\Models\VersionCotizacion;
use App\Services\SendQuoteService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
// Send email with quote
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CotizacionController extends Controller
{
    public function index(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);
        $viewData['cotizaciones'] = Cotizacion::where('proyectoId', $id)
            ->withCount('versionCotizaciones')
            ->with('creador')
            ->orderBy('id')
            ->get();

        return view('tecnico.cotizacion.index')->with('viewData', $viewData);
    }

    public function versions(string $id, string $cotizacionId): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);
        $viewData['cotizacion'] = Cotizacion::findOrFail($cotizacionId);
        $viewData['versiones'] = $viewData['cotizacion']->versionCotizaciones()
            ->orderBy('numeroVersion')
            ->get();
        $viewData['numeroCotizacion'] = Cotizacion::where('proyectoId', $id)
            ->where('id', '<=', $cotizacionId)
            ->count();

        return view('tecnico.cotizacion.versions')->with('viewData', $viewData);
    }

    public function show(string $projectId, string $versionId): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($projectId);
        $viewData['version'] = VersionCotizacion::with([
            'cotizacion',
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.presentacion',
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.tipoMaterial.material',
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.tipoMaterial.tipo.unidadMedida',
        ])->findOrFail($versionId);

        $viewData['materialesVersion'] = $this->buildMateriasVersion($viewData['version']);

        return view('tecnico.cotizacion.show')->with('viewData', $viewData);
    }

    public function create(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);
        $tipoMateriales = TipoMaterial::with([
            'material',
            'tipo.unidadMedida',
            'presentacionTipoMateriales.presentacion',
        ])->get();
        $viewData['tmData'] = $this->buildTmData($tipoMateriales);

        return view('tecnico.cotizacion.create')->with('viewData', $viewData);
    }

    public function store(StoreCotizacionRequest $request, string $id, SendQuoteService $sendQuote): RedirectResponse
    {
        $project = Proyecto::findOrFail($id);
        $cotizacionId = null;
        $versionId = null;

        try {
            Cotizacion::query()->getConnection()->transaction(function () use ($request, $project, &$cotizacionId, &$versionId) {
                $cotizacion = Cotizacion::create([
                    'proyectoId' => $project->getId(),
                    'estado' => 'Tecnico',
                    'creadoPor' => Auth::id(),
                ]);
                $cotizacionId = $cotizacion->getId();

                $version = VersionCotizacion::create([
                    'numeroVersion' => '1',
                    'esLaMasReciente' => true,
                    'cotizacionId' => $cotizacion->getId(),
                ]);
                $versionId = $version->getId();

                foreach ($request->materiales as $item) {
                    PresentacionTipoMaterialVersionCotizacion::create([
                        'cantidad' => $item['cantidad'],
                        'versionCotizacionId' => $version->getId(),
                        'presentacionTipoMaterialId' => $item['presentacionTipoMaterialId'],
                    ]);
                }
            });
        } catch (Exception $e) {
            session()->flash('error', 'No se pudo crear la cotización: '.$e->getMessage());

            return redirect()->route('tecnico.cotizacion.index', $id);
        }

        try {
            $this->generarYGuardarPdf($versionId, $project);
        } catch (Exception $e) {
            session()->flash('error', 'Cotización creada, pero no se pudo generar el PDF: '.$e->getMessage());

            return redirect()->route('tecnico.cotizacion.versions', [$id, $cotizacionId]);
        }

        try {
            $version = VersionCotizacion::findOrFail($versionId);
            $quote = Cotizacion::findOrFail($cotizacionId);
            $userThatModified = User::findOrFail(Auth::id());

            $sendQuote->send(
                $quote->getEstado(),
                'Se ha creado una nueva cotización para '.$project->getNombre(),
                'Se ha creado una nueva cotización con ID '.$cotizacionId.' para el proyecto '.$project->getNombre(),
                $project->getNombre(),
                $userThatModified->getName().' - CC: '.$userThatModified->getCedula(),
                $version->getnumeroVersion(),
                $version->getPdfPath()
            );
        } catch (Exception $e) {
            session()->flash('error', 'Cotización creada, pero no se pudo enviar el correo de notificación.');
        }

        session()->flash('success', 'Cotización creada correctamente para el proyecto "'.$project->getNombre().'".');

        return redirect()->route('tecnico.cotizacion.versions', [$id, $cotizacionId]);
    }

    public function edit(string $projectId, string $versionId): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($projectId);
        $viewData['version'] = VersionCotizacion::with([
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.presentacion',
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.tipoMaterial.material',
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.tipoMaterial.tipo.unidadMedida',
        ])->findOrFail($versionId);

        $tipoMateriales = TipoMaterial::with([
            'material',
            'tipo.unidadMedida',
            'presentacionTipoMateriales.presentacion',
        ])->get();
        $viewData['tmData'] = $this->buildTmData($tipoMateriales);
        $viewData['materialesVersion'] = $this->buildMateriasVersion($viewData['version']);

        return view('tecnico.cotizacion.edit')->with('viewData', $viewData);
    }

    public function update(UpdateCotizacionRequest $request, string $projectId, string $versionId, SendQuoteService $sendQuote): RedirectResponse
    {
        $project = Proyecto::findOrFail($projectId);
        $versionActual = VersionCotizacion::findOrFail($versionId);
        $cotizacion = $versionActual->cotizacion;
        $nuevaVersionId = null;

        $versionMasReciente = $cotizacion->versionCotizaciones()
            ->where('esLaMasReciente', true)
            ->first();
        if ($versionMasReciente && $versionMasReciente->getNumeroVersion() !== '1') {
            $pdfAnteriorPath = $versionMasReciente->getPdfPath();
        } else {
            $pdfAnteriorPath = null;
        }

        try {
            Cotizacion::query()->getConnection()->transaction(function () use ($request, $cotizacion, &$nuevaVersionId) {
                $cotizacion->setEstado('Tecnico Editada');
                $cotizacion->save();

                $cotizacion->versionCotizaciones()->update(['esLaMasReciente' => false]);

                $nuevoNumeroVersion = $cotizacion->versionCotizaciones()->count() + 1;

                $nuevaVersion = VersionCotizacion::create([
                    'numeroVersion' => (string) $nuevoNumeroVersion,
                    'esLaMasReciente' => true,
                    'cotizacionId' => $cotizacion->getId(),
                ]);
                $nuevaVersionId = $nuevaVersion->getId();

                foreach ($request->materiales as $item) {
                    PresentacionTipoMaterialVersionCotizacion::create([
                        'cantidad' => $item['cantidad'],
                        'versionCotizacionId' => $nuevaVersion->getId(),
                        'presentacionTipoMaterialId' => $item['presentacionTipoMaterialId'],
                    ]);
                }
            });
        } catch (Exception $e) {
            session()->flash('error', 'No se pudo actualizar la cotización: '.$e->getMessage());

            return redirect()->route('tecnico.cotizacion.versions', [$project->getId(), $cotizacion->getId()]);
        }

        if ($pdfAnteriorPath && Storage::disk('public')->exists($pdfAnteriorPath)) {
            Storage::disk('public')->delete($pdfAnteriorPath);
            $versionMasReciente->pdfPath = null;
            $versionMasReciente->save();
        }

        try {
            $this->generarYGuardarPdf($nuevaVersionId, $project);
        } catch (Exception $e) {
            session()->flash('error', 'Cotización actualizada, pero no se pudo generar el PDF: '.$e->getMessage());

            return redirect()->route('tecnico.cotizacion.versions', [$project->getId(), $cotizacion->getId()]);
        }

        try {
            $newQuoteVersion = VersionCotizacion::findOrFail($nuevaVersionId);
            $userThatModified = User::findOrFail(Auth::id());

            $sendQuote->send(
                $cotizacion->getEstado(),
                'Se ha editado una cotización de el proyecto '.$project->getNombre(),
                'Se ha editado la cotización con ID '.$cotizacion->getId().' del proyecto '.$project->getNombre(),
                $project->getNombre(),
                $userThatModified->getName().' - CC: '.$userThatModified->getCedula(),
                $newQuoteVersion->getnumeroVersion(),
                $newQuoteVersion->getPdfPath()
            );
        } catch (Exception $e) {
            session()->flash('error', 'Cotización actualizada, pero no se pudo enviar el correo de notificación.');
        }

        session()->flash('success', 'Nueva versión de la cotización creada correctamente.');

        return redirect()->route('tecnico.cotizacion.versions', [$project->getId(), $cotizacion->getId()]);
    }

    public function pdfView(string $projectId, string $versionId): View
    {
        $project = Proyecto::findOrFail($projectId);
        $version = $this->cargarVersionConRelaciones($versionId);
        ['tecnico' => $tecnico, 'fecha' => $fecha, 'materiales' => $materiales, 'numeroCotizacion' => $numeroCotizacion, 'version' => $version] = $this->prepararDatosPdf($version);

        return view('tecnico.cotizacion.pdf-view', compact('project', 'version', 'tecnico', 'fecha', 'materiales', 'numeroCotizacion'));
    }

    public function pdfDownload(string $projectId, string $versionId)
    {
        $project = Proyecto::findOrFail($projectId);
        $version = $this->cargarVersionConRelaciones($versionId);
        ['tecnico' => $tecnico, 'fecha' => $fecha, 'materiales' => $materiales, 'numeroCotizacion' => $numeroCotizacion, 'version' => $version] = $this->prepararDatosPdf($version);

        $numeroVersion = $version->getNumeroVersion();
        $numeroCotizacion = Cotizacion::where('proyectoId', $project->getId())
            ->where('id', '<=', $version->getCotizacion()->getId())
            ->count();

        return Pdf::loadView('pdf.cotizacion', compact('project', 'tecnico', 'fecha', 'materiales', 'numeroCotizacion', 'version'))
            ->setPaper('a4', 'portrait')
            ->download('p'.$project->getId().'_c'.$numeroCotizacion.'_v'.$numeroVersion.'.pdf');
    }

    private function cargarVersionConRelaciones(int|string $versionId): VersionCotizacion
    {
        return VersionCotizacion::with([
            'cotizacion.creador',
            'cotizacion.proyecto',
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.presentacion',
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.tipoMaterial.material',
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.tipoMaterial.tipo.unidadMedida',
        ])->findOrFail($versionId);
    }

    private function prepararDatosPdf(VersionCotizacion $version): array
    {
        $cotizacion = $version->getCotizacion();
        $tecnico = $cotizacion->getCreadoPor();
        $numeroCotizacion = Cotizacion::where('proyectoId', $cotizacion->proyecto->getId())
            ->where('id', '<=', $cotizacion->getId())
            ->count();

        $fecha = Carbon::parse($version->getCreatedAt())->locale('es')->isoFormat('MMMM D, YYYY');

        $materiales = $version->getPresentacionTipoMaterialVersionCotizaciones()->map(function ($item) {
            $ptm = $item->getPresentacionTipoMaterial();
            $tm = $ptm->getTipoMaterial();
            $unidadMedida = $tm->getTipo()->getUnidadMedida();
            $unidades = $ptm->getCantidadPresentacion().($unidadMedida ? ' '.$unidadMedida->getAbreviatura() : '');

            return [
                'cantidad' => $item->getCantidad(),
                'unidades' => $unidades,
                'presentacion' => $ptm->getPresentacion()->getNombre(),
                'descripcion' => $tm->getMaterial()->getDescripcion(),
                'especificacion' => strtoupper($tm->getTipo()->getEspecificacion()),
            ];
        });

        return compact('tecnico', 'fecha', 'materiales', 'numeroCotizacion', 'version');
    }

    private function generarYGuardarPdf(int $versionId, Proyecto $project): void
    {
        $version = $this->cargarVersionConRelaciones($versionId);
        ['tecnico' => $tecnico, 'fecha' => $fecha, 'materiales' => $materiales, 'numeroCotizacion' => $numeroCotizacion, 'version' => $version] = $this->prepararDatosPdf($version);

        $pdf = Pdf::loadView('pdf.cotizacion', compact('project', 'tecnico', 'fecha', 'materiales', 'numeroCotizacion', 'version'))
            ->setPaper('a4', 'portrait');

        $numeroVersion = $version->getNumeroVersion();
        $relativePath = 'proyecto_'.$project->getId()
            .'/cotizacion_'.$numeroCotizacion
            .'/p'.$project->getId().'_c'.$numeroCotizacion.'_v'.$numeroVersion.'.pdf';
        Storage::disk('public')->put($relativePath, $pdf->output());

        $version->pdfPath = $relativePath;
        $version->save();
    }

    private function buildTmData($tipoMateriales): array
    {
        return $tipoMateriales->mapWithKeys(function ($tm) {
            $unidadMedida = $tm->getTipo()->getUnidadMedida();

            return [$tm->getId() => [
                'label' => $tm->getMaterial()->getDescripcion().' — '.$tm->getTipo()->getEspecificacion(),
                'presentaciones' => $tm->getPresentacionTipoMateriales()->map(function ($ptm) use ($unidadMedida) {
                    return [
                        'id' => $ptm->getId(),
                        'nombre' => $ptm->getPresentacion()->getNombre(),
                        'unidad' => $ptm->getCantidadPresentacion().($unidadMedida ? ' '.$unidadMedida->getAbreviatura() : ''),
                    ];
                })->values(),
            ]];
        })->all();
    }

    private function buildMateriasVersion(VersionCotizacion $version): Collection
    {
        return $version->getPresentacionTipoMaterialVersionCotizaciones()->map(function ($item) {
            $ptm = $item->getPresentacionTipoMaterial();
            $tm = $ptm->getTipoMaterial();
            $unidadMedida = $tm->getTipo()->getUnidadMedida();

            return [
                'ptmId' => $ptm->getId(),
                'descripcion' => $tm->getMaterial()->getDescripcion(),
                'especificacion' => $tm->getTipo()->getEspecificacion(),
                'presentacion' => $ptm->getPresentacion()->getNombre(),
                'unidad' => $ptm->getCantidadPresentacion().($unidadMedida ? ' '.$unidadMedida->getAbreviatura() : ''),
                'cantidad' => $item->getCantidad(),
            ];
        });
    }
}
