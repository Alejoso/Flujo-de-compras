<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\SaveClienteRequest;
use App\Http\Requests\Cliente\UpdateClienteRequest;
use App\Models\Cliente;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['clients'] = Cliente::orderBy('id', 'asc')->paginate(12);

        return view('admin.client.index')->with('viewData', $viewData);
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
            session()->flash('success', __('cliente.success_created').$project->getNombre());
        } catch (Exception $e) {
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

        return view('admin.client.edit')->with('viewData', $viewData);
    }

    public function update(UpdateClienteRequest $request, string $id): RedirectResponse
    {
        $validatedClientData = $request->validated();

        try {
            $client = Cliente::findOrFail($id);
            $client->update($validatedClientData);
            session()->flash('success', __('cliente.success_edited').$client->getNombre());
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('admin.client.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $client = Cliente::findOrFail($id);

            if ($client->proyectos()->exists()) {
                session()->flash('error', __('cliente.cant_delete').$client->getNombre().__('cliente.cant_delete_why'));

                return redirect()->route('admin.client.index');
            }

            $client->delete();
            session()->flash('success', __('cliente.success_deleted').$client->getNombre());
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('admin.client.index');
    }
}
