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
use App\Services\SendMessageFactory;
use App\Support\Cotizacion\CotizacionBuilder;
// Send email with quote
use App\Support\Cotizacion\CotizacionPdfBuilder;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CotizacionController extends Controller
{
    public function __construct(
        private readonly CotizacionBuilder $builder,
        private readonly CotizacionPdfBuilder $pdfBuilder,
    ) {}

    // Muestra la lista de cotizaciones de un proyecto.
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

    // Muestra todas las versiones de una cotización específica.
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

    // Muestra el detalle de una versión específica con sus materiales.
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

        $viewData['materialesVersion'] = $this->builder->buildMateriasVersion($viewData['version']);

        return view('tecnico.cotizacion.show')->with('viewData', $viewData);
    }

    // Muestra el formulario para crear una nueva cotización con los materiales disponibles.
    public function create(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);
        $tipoMateriales = TipoMaterial::with([
            'material',
            'tipo.unidadMedida',
            'presentacionTipoMateriales.presentacion',
        ])->get();
        $viewData['tmData'] = $this->builder->buildTmData($tipoMateriales);

        return view('tecnico.cotizacion.create')->with('viewData', $viewData);
    }

    // Guarda una nueva cotización con su primera versión y materiales. Genera el PDF y envía notificación por correo.
    public function store(StoreCotizacionRequest $request, string $id): RedirectResponse
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
            session()->flash('error', __('tecnico_cotizacion.flash_store_error', ['error' => $e->getMessage()]));

            return redirect()->route('tecnico.cotizacion.index', $id);
        }

        try {
            $this->pdfBuilder->generarYGuardarPdf($versionId, $project);
        } catch (Exception $e) {
            session()->flash('error', __('tecnico_cotizacion.flash_store_pdf_error', ['error' => $e->getMessage()]));

            return redirect()->route('tecnico.cotizacion.versions', [$id, $cotizacionId]);
        }

        try {
            $sendMessage = app(SendMessageFactory::class)->make('email');

            $version = VersionCotizacion::findOrFail($versionId);
            $quote = Cotizacion::findOrFail($cotizacionId);
            $userThatModified = User::findOrFail(Auth::id());
            $position = Cotizacion::where('proyectoId', $project->getId())
                ->where('id', '<=', $cotizacionId)
                ->orderBy('id')
                ->count();

            $sendMessage->send(
                $quote->getEstado(),
                __('email.quote_created_subject', ['project' => $project->getNombre()]),
                __('email.quote_created_body', ['id' => $position, 'project' => $project->getNombre()]),
                $project->getNombre(),
                $userThatModified->getName().' - CC: '.$userThatModified->getCedula(),
                $version->getnumeroVersion(),
                $version->getPdfPath()
            );
        } catch (Exception $e) {
            session()->flash('error', __('email.quote_created_error'));
        }

        session()->flash('success', __('tecnico_cotizacion.flash_store_success', ['project' => $project->getNombre()]));

        return redirect()->route('tecnico.cotizacion.versions', [$id, $cotizacionId]);
    }

    // Muestra el formulario para editar los materiales de la versión más reciente de una cotización.
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
        $viewData['tmData'] = $this->builder->buildTmData($tipoMateriales);
        $viewData['materialesVersion'] = $this->builder->buildMateriasVersion($viewData['version']);

        return view('tecnico.cotizacion.edit')->with('viewData', $viewData);
    }

    // Crea una nueva versión de la cotización con los materiales actualizados, regenera el PDF y envía notificación por correo.
    public function update(UpdateCotizacionRequest $request, string $projectId, string $versionId): RedirectResponse
    {
        $project = Proyecto::findOrFail($projectId);
        $versionActual = VersionCotizacion::findOrFail($versionId);
        $cotizacion = $versionActual->cotizacion;
        $versionMasReciente = $cotizacion->versionCotizaciones()->where('esLaMasReciente', true)->first();
        $pdfAnteriorPath = ($versionMasReciente && $versionMasReciente->getNumeroVersion() !== '1')
            ? $versionMasReciente->getPdfPath()
            : null;

        try {
            $nuevaVersionId = $this->crearNuevaVersion($cotizacion, $request->materiales);
        } catch (Exception $e) {
            session()->flash('error', __('tecnico_cotizacion.flash_update_error', ['error' => $e->getMessage()]));

            return redirect()->route('tecnico.cotizacion.versions', [$project->getId(), $cotizacion->getId()]);
        }

        $this->pdfBuilder->eliminarPdfAnterior($pdfAnteriorPath, $versionMasReciente);

        try {
            $this->pdfBuilder->generarYGuardarPdf($nuevaVersionId, $project);
        } catch (Exception $e) {
            session()->flash('error', __('tecnico_cotizacion.flash_update_pdf_error', ['error' => $e->getMessage()]));

            return redirect()->route('tecnico.cotizacion.versions', [$project->getId(), $cotizacion->getId()]);
        }

        try {
            $this->enviarEmailEdicion($cotizacion, $project, VersionCotizacion::findOrFail($nuevaVersionId));
        } catch (Exception $e) {
            session()->flash('error', __('email.quote_edited_error'));
        }

        session()->flash('success', __('tecnico_cotizacion.flash_update_success'));

        return redirect()->route('tecnico.cotizacion.versions', [$project->getId(), $cotizacion->getId()]);
    }

    // Crea una nueva versión de la cotización con los materiales actualizados dentro de una transacción para asegurar la integridad de los datos.
    private function crearNuevaVersion(Cotizacion $cotizacion, array $materiales): int
    {
        $nuevaVersionId = null;

        Cotizacion::query()->getConnection()->transaction(function () use ($cotizacion, $materiales, &$nuevaVersionId) {
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

            foreach ($materiales as $item) {
                PresentacionTipoMaterialVersionCotizacion::create([
                    'cantidad' => $item['cantidad'],
                    'versionCotizacionId' => $nuevaVersion->getId(),
                    'presentacionTipoMaterialId' => $item['presentacionTipoMaterialId'],
                ]);
            }
        });

        return $nuevaVersionId;
    }

    // Envía un correo notificando la edición de la cotización con los detalles del proyecto, versión y usuario que realizó la modificación.
    private function enviarEmailEdicion(Cotizacion $cotizacion, Proyecto $project, VersionCotizacion $version): void
    {
        $sendMessage = app(SendMessageFactory::class)->make('email');
        $userThatModified = User::findOrFail(Auth::id());
        $position = Cotizacion::where('proyectoId', $project->getId())
            ->where('id', '<=', $cotizacion->getId())
            ->orderBy('id')
            ->count();

        $sendMessage->send(
            $cotizacion->getEstado(),
            __('email.quote_edited_subject', ['project' => $project->getNombre()]),
            __('email.quote_edited_body', ['id' => $position, 'project' => $project->getNombre()]),
            $project->getNombre(),
            $userThatModified->getName().' - CC: '.$userThatModified->getCedula(),
            $version->getnumeroVersion(),
            $version->getPdfPath()
        );
    }
}
