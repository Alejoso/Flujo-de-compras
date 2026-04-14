<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\SaveClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search', '');

        $viewData = [];
        $viewData['clients'] = Client::when($search, fn ($q) => $q->where('name', 'ilike', "%{$search}%"))
            ->orderBy('name', 'asc')
            ->paginate(12);

        $viewData['search'] = $search;

        return view('admin.client.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('admin.client.create');
    }

    public function save(SaveClientRequest $request): RedirectResponse
    {
        $validatedClientData = $request->validated();

        try {
            $client = Client::create($validatedClientData);
            session()->flash('success', __('cliente.success_created', ['name' => $client->getName()]));
        } catch (Exception $e) {
            session()->flash('error', __('cliente.flash_save_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.client.index');
    }

    public function show(string $id): View
    {
        $viewData = [];
        $viewData['client'] = Client::findOrFail($id);

        return view('admin.client.show')->with('viewData', $viewData);
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['client'] = Client::findOrFail($id);

        return view('admin.client.edit')->with('viewData', $viewData);
    }

    public function update(UpdateClientRequest $request, string $id): RedirectResponse
    {
        $validatedClientData = $request->validated();

        try {
            $client = Client::findOrFail($id);
            $client->update($validatedClientData);
            session()->flash('success', __('cliente.success_edited', ['name' => $client->getName()]));
        } catch (Exception $e) {
            session()->flash('error', __('cliente.flash_update_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.client.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $client = Client::findOrFail($id);

            if ($client->projects()->exists()) {
                session()->flash('error', __('cliente.cant_delete', ['name' => $client->getName()]));

                return redirect()->route('admin.client.index');
            }

            $client->delete();
            session()->flash('success', __('cliente.success_deleted', ['name' => $client->getName()]));
        } catch (Exception $e) {
            session()->flash('error', __('cliente.flash_delete_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.client.index');
    }
}
