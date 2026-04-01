<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Cliente;
use App\Http\Requests\Cliente\SaveClienteRequest;
use App\Http\Requests\Cliente\UpdateClienteRequest;
use Exception;

class ClientController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['clients'] = Cliente::orderBy('id','asc')->paginate(12);

        return view('admin.client.index')->with('viewData' , $viewData);
    }

    public function create(): View
    {
        return view('admin.client.create');
    }

    public function save(SaveClienteRequest $request): RedirectResponse
    {
        $validatedProjectData = $request->validated();

        try {
            $project = Cliente::create($validatedProjectData);
            session()->flash('success','Se ha creado con exito el cliente ' . $project->getNombre());
        } 
        catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('admin.client.index');
    }

    public function show(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Cliente::findOrFail($id);

        return view('admin.project.show');
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['client'] = Cliente::findOrFail($id);

        return view('admin.client.edit')->with('viewData' , $viewData);
    }

    public function update(UpdateClienteRequest $request , string $id): RedirectResponse
    {
        $validatedClientData = $request->validated();
        try {
            $client = Cliente::findOrFail($id);
            $client->update($validatedClientData);
            session()->flash('success','Se ha actualizado al cliente'. $client->getNombre());
        } 
        catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('admin.client.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        try{
            $client = Cliente::findOrFail($id);
            $client->delete();
            session()->flash('success','Se ha eliminado exitosamente el cliente '. $client->getNombre());
        }
        catch (Exception $e) { 
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('admin.client.index');
    }


}
