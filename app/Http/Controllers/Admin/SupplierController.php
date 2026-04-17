<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\SaveSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search', '');

        $viewData = [];
        $viewData['suppliers'] = Supplier::when($search, fn ($q) => $q->where('name', 'ilike', "%{$search}%"))
            ->orderBy('name', 'asc')
            ->paginate(12);
        $viewData['search'] = $search;

        return view('admin.supplier.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('admin.supplier.create');
    }

    public function save(SaveSupplierRequest $request): RedirectResponse
    {
        try {
            $supplier = Supplier::create($request->validated());
            session()->flash('success', __('supplier.success_created', ['name' => $supplier->getName()]));
        } catch (Exception $e) {
            session()->flash('error', __('supplier.flash_save_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.supplier.index');
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['supplier'] = Supplier::findOrFail($id);

        return view('admin.supplier.edit')->with('viewData', $viewData);
    }

    public function update(UpdateSupplierRequest $request, string $id): RedirectResponse
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->update($request->validated());
            session()->flash('success', __('supplier.success_edited', ['name' => $supplier->getName()]));
        } catch (Exception $e) {
            session()->flash('error', __('supplier.flash_update_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.supplier.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $supplier = Supplier::findOrFail($id);

            if ($supplier->invoices()->exists()) {
                session()->flash('error', __('supplier.cant_delete', ['name' => $supplier->getName()]));

                return redirect()->route('admin.supplier.index');
            }

            $supplier->delete();
            session()->flash('success', __('supplier.success_deleted', ['name' => $supplier->getName()]));
        } catch (Exception $e) {
            session()->flash('error', __('supplier.flash_delete_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.supplier.index');
    }
}
