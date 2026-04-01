<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCotizacionRequest;
use App\Http\Requests\UpdateCotizacionRequest;
use App\Models\Cotizacion;
use App\Models\Proyecto;
use App\Models\TipoMaterial;
use App\Models\TipoMaterialVersionCotizacion;
use App\Models\VersionCotizacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
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
            'tipoMaterialVersionCotizaciones.tipoMaterial.material',
            'tipoMaterialVersionCotizaciones.tipoMaterial.tipo.unidadMedidaCantidades.unidadMedida',
        ])->findOrFail($versionId);

        return view('tecnico.cotizacion.show')->with('viewData', $viewData);
    }

    public function create(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);
        $tipoMateriales = TipoMaterial::with([
            'material',
            'tipo.unidadMedidaCantidades.unidadMedida',
        ])->get();

        $viewData['tipoMateriales'] = $tipoMateriales;

        return view('tecnico.cotizacion.create')->with('viewData', $viewData);
    }

    public function store(StoreCotizacionRequest $request, string $id): RedirectResponse
    {
        $project = Proyecto::findOrFail($id);
        $cotizacionId = null;
        $versionId = null;

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
                TipoMaterialVersionCotizacion::create([
                    'cantidad' => $item['cantidad'],
                    'versionCotizacionId' => $version->getId(),
                    'tipoMaterialId' => $item['tipoMaterialId'],
                ]);
            }
        });

        $this->generarYGuardarPdf($versionId, $project);

        session()->flash('success', 'Cotización creada correctamente para el proyecto "'.$project->getNombre().'".');

        return redirect()->route('tecnico.cotizacion.versions', [$id, $cotizacionId]);
    }

    public function edit(string $projectId, string $versionId): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($projectId);

        $viewData['version'] = VersionCotizacion::with('tipoMaterialVersionCotizaciones')
            ->findOrFail($versionId);

        $tipoMateriales = TipoMaterial::with([
            'material',
            'tipo.unidadMedidaCantidades.unidadMedida',
        ])->get();

        $viewData['tipoMateriales'] = $tipoMateriales;

        return view('tecnico.cotizacion.edit')->with('viewData', $viewData);
    }

    public function update(UpdateCotizacionRequest $request, string $projectId, string $versionId): RedirectResponse
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

        Cotizacion::query()->getConnection()->transaction(function () use ($request, $cotizacion, &$nuevaVersionId) {
            $cotizacion->versionCotizaciones()->update(['esLaMasReciente' => false]);

            $nuevoNumeroVersion = $cotizacion->versionCotizaciones()->count() + 1;

            $nuevaVersion = VersionCotizacion::create([
                'numeroVersion' => (string) $nuevoNumeroVersion,
                'esLaMasReciente' => true,
                'cotizacionId' => $cotizacion->getId(),
            ]);
            $nuevaVersionId = $nuevaVersion->getId();

            foreach ($request->materiales as $item) {
                TipoMaterialVersionCotizacion::create([
                    'cantidad' => $item['cantidad'],
                    'versionCotizacionId' => $nuevaVersion->getId(),
                    'tipoMaterialId' => $item['tipoMaterialId'],
                ]);
            }
        });

        if ($pdfAnteriorPath && Storage::disk('public')->exists($pdfAnteriorPath)) {
            Storage::disk('public')->delete($pdfAnteriorPath);
            $versionMasReciente->pdfPath = null;
            $versionMasReciente->save();
        }

        $this->generarYGuardarPdf($nuevaVersionId, $project);

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

        $cotizacionId = $version->getCotizacion()->getId();
        $numeroVersion = $version->getNumeroVersion();

        return Pdf::loadView('pdf.cotizacion', compact('project', 'tecnico', 'fecha', 'materiales', 'numeroCotizacion', 'version'))
            ->setPaper('a4', 'portrait')
            ->download('cotizacion_'.$cotizacionId.'_v'.$numeroVersion.'.pdf');
    }

    private function cargarVersionConRelaciones(int|string $versionId): VersionCotizacion
    {
        return VersionCotizacion::with([
            'cotizacion.creador',
            'tipoMaterialVersionCotizaciones.tipoMaterial.material',
            'tipoMaterialVersionCotizaciones.tipoMaterial.tipo.unidadMedidaCantidades.unidadMedida',
        ])->findOrFail($versionId);
    }

    private function prepararDatosPdf(VersionCotizacion $version): array
    {
        $cotizacion = $version->getCotizacion();
        $tecnico = $cotizacion->getCreadoPor();
        $numeroCotizacion = $cotizacion->getId();

        $fecha = Carbon::parse($version->getCreatedAt())->locale('es')->isoFormat('MMMM D, YYYY');

        $materiales = $version->getTipoMaterialVersionCotizaciones()->map(function ($item) {
            $unidades = $item->getTipoMaterial()->getTipo()->getUnidadMedidaCantidades()
                ->map(fn ($umc) => $umc->getUnidadMedida()->getAbreviatura())
                ->unique()->implode(' / ');

            return [
                'cantidad' => $item->getCantidad(),
                'unidades' => $unidades,
                'descripcion' => $item->getTipoMaterial()->getMaterial()->getDescripcion(),
                'especificacion' => strtoupper($item->getTipoMaterial()->getTipo()->getEspecificacion()),
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

        $cotizacionId = $version->getCotizacion()->getId();
        $numeroVersion = $version->getNumeroVersion();
        $relativePath = 'cotizaciones/cotizacion_'.$cotizacionId.'_v'.$numeroVersion.'.pdf';
        Storage::disk('public')->put($relativePath, $pdf->output());

        $version->pdfPath = $relativePath;
        $version->save();
    }
}
