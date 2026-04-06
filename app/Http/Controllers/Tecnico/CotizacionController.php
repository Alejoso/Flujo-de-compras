<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCotizacionRequest;
use App\Http\Requests\UpdateCotizacionRequest;
use App\Models\Cotizacion;
use App\Models\Proyecto;
use App\Models\TipoMaterial;
use App\Models\VersionCotizacion;
use App\Services\CotizacionService;
use App\Support\Cotizacion\CotizacionBuilder;
use App\Support\Cotizacion\CotizacionMailer;
use App\Support\Cotizacion\CotizacionPdfBuilder;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CotizacionController extends Controller
{
    public function __construct(
        private readonly CotizacionBuilder $builder,
        private readonly CotizacionPdfBuilder $pdfBuilder,
        private readonly CotizacionService $cotizacionService,
        private readonly CotizacionMailer $mailer,
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
        $viewData['versionActual'] = $viewData['versiones']->firstWhere('esLaMasReciente', true);
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

        try {
            ['cotizacionId' => $cotizacionId, 'versionId' => $versionId] =
                $this->cotizacionService->crearCotizacion($project, $request->materiales);
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
            $this->mailer->enviarEmailCreacion(
                Cotizacion::findOrFail($cotizacionId),
                $project,
                VersionCotizacion::findOrFail($versionId)
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
            $nuevaVersionId = $this->cotizacionService->crearNuevaVersion($cotizacion, $request->materiales);
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
            $this->mailer->enviarEmailEdicion($cotizacion, $project, VersionCotizacion::findOrFail($nuevaVersionId));
        } catch (Exception $e) {
            session()->flash('error', __('email.quote_edited_error'));
        }

        session()->flash('success', __('tecnico_cotizacion.flash_update_success'));

        return redirect()->route('tecnico.cotizacion.versions', [$project->getId(), $cotizacion->getId()]);
    }
}
