@extends('layouts.admin')
@section('page-title', 'Materiales')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/materiales.css') }}">
@endpush

@section('content')
  <div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header" style="gap: 1rem; flex-wrap: wrap;">
      <h1 class="um-title" style="font-size: clamp(1.5rem, 5vw, 2rem); margin-bottom: 0;"><i class="bi bi-box-seam"></i>
        Materiales</h1>
      <a href="{{ route('admin.material.create') }}" class="um-btn-primary"
        style="font-size: clamp(0.85rem, 2vw, 1rem); min-height: 44px;">
        <i class="bi bi-plus-lg me-1"></i> <span class="d-none d-sm-inline">Nuevo Material</span>
      </a>
    </div>

    {{-- Card --}}
    <div class="um-card mb-3 mb-md-4">
      <div class="um-card-header" style="flex-direction: column; gap: 1rem; align-items: flex-start;">
        <div>
          <p class="um-card-title" style="font-size: clamp(1.1rem, 4vw, 1.25rem);">Catálogo de materiales</p>
          <p class="um-card-subtitle" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">Materiales con sus tipos y
            presentaciones</p>
        </div>
        <form action="{{ route('admin.material.index') }}" method="GET" class="d-flex gap-2 search-group"
          style="width: 100%;">
          <div class="input-group" style="width: 100%;">
            <span class="input-group-text" style="min-width: 44px;"><i class="bi bi-search"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Buscar material..."
              value="{{ $viewData['search'] }}" style="font-size: clamp(0.85rem, 2vw, 1rem); min-height: 44px;">
          </div>
        </form>
      </div>

      <div class="um-table-wrapper">
        <table class="um-table">
          <thead>
            <tr>
              <th>Material</th>
              <th>Tipos</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($viewData['materiales'] as $material)
              <tr class="um-row">
                <td data-label="Material">
                  <span class="um-user-name"
                    style="font-size: clamp(0.9rem, 2vw, 1rem);">{{ $material->getDescripcion() }}</span>
                </td>
                <td data-label="Tipos">
                  @foreach ($material->getTipoMateriales() as $tm)
                    <span class="um-badge um-badge--technician me-1 mb-1"
                      style="font-size: clamp(0.75rem, 2vw, 0.85rem);">
                      {{ $tm->getTipo()->getEspecificacion() }}
                      @if ($tm->getTipo()->getUnidadMedida())
                        ({{ $tm->getTipo()->getUnidadMedida()->getAbreviatura() }})
                      @endif
                    </span>
                  @endforeach
                </td>
                <td data-label="Acciones">
                  <div class="um-actions">
                    <form action="{{ route('admin.material.destroy', $material->getId()) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar este material y todos sus tipos?')"
                      style="display: flex; justify-content: center;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="um-btn-icon um-btn-icon--delete"
                        style="min-height: 44px; min-width: 44px;">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="um-empty">No hay materiales registrados.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Paginación --}}
    <div class="d-flex justify-content-center mt-3" style="overflow-x: auto; font-size: clamp(0.8rem, 2vw, 0.95rem);">
      {{ $viewData['materiales']->appends(['search' => $viewData['search']])->links() }}
    </div>

  </div>
@endsection
