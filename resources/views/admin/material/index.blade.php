@extends('layouts.admin')
@section('page-title', 'Materiales')

@section('content')
  <div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-box-seam"></i> Materiales</h1>
      <a href="{{ route('admin.material.create') }}" class="um-btn-primary">
        <i class="bi bi-plus-lg"></i> Nuevo Material
      </a>
    </div>

    {{-- Card --}}
    <div class="um-card">
      <div class="um-card-header">
        <div>
          <p class="um-card-title">Catálogo de materiales</p>
          <p class="um-card-subtitle">Materiales con sus tipos y presentaciones</p>
        </div>
        <form action="{{ route('admin.material.index') }}" method="GET" class="d-flex gap-2 ms-auto search-group">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Buscar material..."
              value="{{ $viewData['search'] }}">
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
                  <span class="um-user-name">{{ $material->getDescripcion() }}</span>
                </td>
                <td data-label="Tipos">
                  @foreach ($material->getTipoMateriales() as $tm)
                    <span class="um-badge um-badge--technician me-1 mb-1">
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
                      onsubmit="return confirm('¿Eliminar este material y todos sus tipos?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="um-btn-icon um-btn-icon--delete">
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
    <div class="d-flex justify-content-center mt-3">
      {{ $viewData['materiales']->appends(['search' => $viewData['search']])->links() }}
    </div>

  </div>
@endsection
