<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use App\Models\Proyecto;
use App\Models\TipoMaterial;
use App\Models\VersionCotizacion;
use App\Models\TipoMaterialVersionCotizacion;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreCotizacionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CotizacionController extends Controller
{
    public function index(string $id): View
    {
        $viewData = [];
        $viewData['project']  = Proyecto::findOrFail($id);
        $cotizacion           = Cotizacion::where('proyectoId', $id)->first();
        $viewData['versiones'] = $cotizacion
            ? $cotizacion->versionCotizaciones()->with('cotizacion')->orderBy('numeroVersion')->get()
            : collect();

        return view('tecnico.cotizacion.index')->with('viewData', $viewData);
    }

    public function show(string $projectId, string $versionId): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($projectId);
        $viewData['version'] = VersionCotizacion::with([
            'tipoMaterialVersionCotizaciones.tipoMaterial.material',
            'tipoMaterialVersionCotizaciones.tipoMaterial.tipo.unidadMedidaCantidades.unidadMedida',
        ])->findOrFail($versionId);

        return view('tecnico.cotizacion.show')->with('viewData', $viewData);
    }

    public function create(string $id): View
    {
        $viewData = [];
        $viewData['project']       = Proyecto::findOrFail($id);
        $tipoMateriales = TipoMaterial::with([
            'material',
            'tipo.unidadMedidaCantidades.unidadMedida',
        ])->get();

        $viewData['tipoMateriales'] = $tipoMateriales;
        $viewData['tipoMaterialesJson'] = $tipoMateriales->map(function ($tm) {
            $unidades = $tm->getTipo()->getUnidadMedidaCantidades()
                ->map(fn($umc) => $umc->getUnidadMedida()->getAbreviatura())
                ->unique()->values();

            return [
                'id'      => $tm->getId(),
                'label'   => $tm->getMaterial()->getDescripcion() . ' — ' . $tm->getTipo()->getEspecificacion(),
                'unidades' => $unidades,
            ];
        });

        return view('tecnico.cotizacion.create')->with('viewData', $viewData);
    }

    public function store(StoreCotizacionRequest $request, string $id): RedirectResponse
    {
        $project = Proyecto::findOrFail($id);

        Cotizacion::query()->getConnection()->transaction(function () use ($request, $project) {
            $cotizacion = Cotizacion::firstOrCreate(
                ['proyectoId' => $project->getId()],
                ['estado' => 'Tecnico', 'creadoPor' => Auth::id()]
            );

            $cotizacion->versionCotizaciones()->update(['esLaMasReciente' => false]);

            $numeroVersion = $cotizacion->versionCotizaciones()->count() + 1;

            $version = VersionCotizacion::create([
                'numeroVersion'   => (string) $numeroVersion,
                'esLaMasReciente' => true,
                'cotizacionId'    => $cotizacion->getId(),
            ]);

            foreach ($request->materiales as $item) {
                TipoMaterialVersionCotizacion::create([
                    'cantidad'            => $item['cantidad'],
                    'versionCotizacionId' => $version->getId(),
                    'tipoMaterialId'      => $item['tipoMaterialId'],
                ]);
            }
        });

        session()->flash('success', 'Cotización enviada correctamente para el proyecto "' . $project->getNombre() . '".');

        return redirect()->route('tecnico.project.index');
    }
}
