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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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
        $viewData['tipoMaterialesJson'] = $tipoMateriales->map(function ($tm) {
            $unidades = $tm->getTipo()->getUnidadMedidaCantidades()
                ->map(fn ($umc) => $umc->getUnidadMedida()->getAbreviatura())
                ->unique()->values();

            return [
                'id' => $tm->getId(),
                'label' => $tm->getMaterial()->getDescripcion().' — '.$tm->getTipo()->getEspecificacion(),
                'unidades' => $unidades,
            ];
        });

        return view('tecnico.cotizacion.create')->with('viewData', $viewData);
    }

    public function store(StoreCotizacionRequest $request, string $id): RedirectResponse
    {
        $project = Proyecto::findOrFail($id);
        $cotizacionId = null;

        Cotizacion::query()->getConnection()->transaction(function () use ($request, $project, &$cotizacionId) {
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

            foreach ($request->materiales as $item) {
                TipoMaterialVersionCotizacion::create([
                    'cantidad' => $item['cantidad'],
                    'versionCotizacionId' => $version->getId(),
                    'tipoMaterialId' => $item['tipoMaterialId'],
                ]);
            }
        });

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
        $viewData['tipoMaterialesJson'] = $tipoMateriales->map(function ($tm) {
            $unidades = $tm->getTipo()->getUnidadMedidaCantidades()
                ->map(fn ($umc) => $umc->getUnidadMedida()->getAbreviatura())
                ->unique()->values();

            return [
                'id' => $tm->getId(),
                'label' => $tm->getMaterial()->getDescripcion().' — '.$tm->getTipo()->getEspecificacion(),
                'unidades' => $unidades,
            ];
        });

        return view('tecnico.cotizacion.edit')->with('viewData', $viewData);
    }

    public function update(UpdateCotizacionRequest $request, string $projectId, string $versionId): RedirectResponse
    {
        $project = Proyecto::findOrFail($projectId);
        $versionActual = VersionCotizacion::findOrFail($versionId);
        $cotizacion = $versionActual->cotizacion;

        Cotizacion::query()->getConnection()->transaction(function () use ($request, $cotizacion) {
            $cotizacion->versionCotizaciones()->update(['esLaMasReciente' => false]);

            $nuevoNumeroVersion = $cotizacion->versionCotizaciones()->count() + 1;

            $nuevaVersion = VersionCotizacion::create([
                'numeroVersion' => (string) $nuevoNumeroVersion,
                'esLaMasReciente' => true,
                'cotizacionId' => $cotizacion->getId(),
            ]);

            foreach ($request->materiales as $item) {
                TipoMaterialVersionCotizacion::create([
                    'cantidad' => $item['cantidad'],
                    'versionCotizacionId' => $nuevaVersion->getId(),
                    'tipoMaterialId' => $item['tipoMaterialId'],
                ]);
            }
        });

        session()->flash('success', 'Nueva versión de la cotización creada correctamente.');

        return redirect()->route('tecnico.cotizacion.versions', [$project->getId(), $cotizacion->getId()]);
    }
}
