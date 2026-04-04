@extends('layouts.tecnico')
@section('page-title', __('tecnico_cotizacion.title_edit'))

@section('content')
  <div class="pj-wrapper" id="cotizacion-app"
    data-search-url="{{ route('tecnico.materiales.search') }}"
    data-row-idx="{{ count($viewData['materialesVersion']) }}"
    data-has-empty-row="0">

    <div class="um-header">
      <h1 class="um-title">
        <i class="bi bi-pencil-square me-2"></i>
        {{ __('tecnico_cotizacion.new_version_from', ['version' => $viewData['version']->getNumeroVersion()]) }}
      </h1>
      <a href="{{ route('tecnico.cotizacion.show', [$viewData['project']->getId(), $viewData['version']->getId()]) }}"
        class="um-btn-icon um-btn-icon--secondary px-3 py-2">
        <i class="bi bi-x-circle me-1"></i> {{ __('tecnico_cotizacion.btn_cancel') }}
      </a>
    </div>

    <form action="{{ route('tecnico.cotizacion.update', [$viewData['project']->getId(), $viewData['version']->getId()]) }}"
      method="POST">
      @csrf
      @method('PATCH')

      <div class="cot-header-card mb-4">
        <p class="cot-project-name">
          <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getNombre() }}
        </p>

        <div class="row mt-3 g-2 align-items-end">
          <div class="col-md-4">
            <label class="form-label fw-bold">{{ __('tecnico_cotizacion.label_material') }}</label>
            <div class="ac-wrap">
              <input type="text" id="buscador-material" class="form-control"
                placeholder="{{ __('tecnico_cotizacion.msg_search_placeholder') }}" autocomplete="off">
              <div id="autocomplete-list" class="ac-dropdown"></div>
            </div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold">{{ __('tecnico_cotizacion.label_presentation') }}</label>
            <select id="selector-presentacion" class="form-select" disabled>
              <option value="">— elige material primero —</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label fw-bold">{{ __('tecnico_cotizacion.label_unit') }}</label>
            <input type="text" id="display-unidad" class="form-control" readonly placeholder="—">
          </div>
          <div class="col-md-3">
            <button type="button" id="btn-add-material" class="btn btn-primary w-100" disabled>
              <i class="bi bi-plus-lg me-1"></i> {{ __('tecnico_cotizacion.btn_add_material') }}
            </button>
          </div>
        </div>
      </div>

      <div class="cot-table-wrap">
        <table class="cot-table cot-edit-table" id="tabla-materiales">
          <thead>
            <tr>
              <th>{{ __('tecnico_cotizacion.th_material_spec') }}</th>
              <th>{{ __('tecnico_cotizacion.label_presentation') }}</th>
              <th>{{ __('tecnico_cotizacion.label_unit') }}</th>
              <th class="col-cantidad">{{ __('tecnico_cotizacion.label_quantity') }}</th>
              <th class="col-actions"></th>
            </tr>
          </thead>
          <tbody id="lista-materiales">
            @foreach ($viewData['materialesVersion'] as $index => $mat)
              <tr data-id="{{ $mat['ptmId'] }}">
                <td>
                  {{ $mat['descripcion'] }} — {{ $mat['especificacion'] }}
                  <input type="hidden" name="materiales[{{ $index }}][presentacionTipoMaterialId]"
                    value="{{ $mat['ptmId'] }}">
                </td>
                <td>{{ $mat['presentacion'] }}</td>
                <td>{{ $mat['unidad'] }}</td>
                <td>
                  <input type="number" name="materiales[{{ $index }}][cantidad]" class="form-control"
                    value="{{ $mat['cantidad'] }}" step="0.01" required>
                </td>
                <td>
                  <button type="button" class="btn btn-link text-danger btn-remove"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-4 d-flex justify-content-end">
        <button type="submit" class="btn btn-success px-5 py-2">
          <i class="bi bi-save me-1"></i> {{ __('tecnico_cotizacion.btn_save_version') }}
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/tecnico/cotizacion-form.js')
@endpush
