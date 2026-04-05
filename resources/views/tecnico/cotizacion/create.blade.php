@extends('layouts.tecnico')
@section('page-title', __('tecnico_cotizacion.title_create'))

@section('content')
  <div class="pj-wrapper" id="cotizacion-app"
    data-search-url="{{ route('tecnico.materiales.search') }}"
    data-row-idx="0"
    data-has-empty-row="1">

    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-clipboard-plus me-2"></i>{{ __('tecnico_cotizacion.title_create') }}</h1>
      <a href="{{ route('tecnico.cotizacion.index', $viewData['project']->getId()) }}"
        class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> {{ __('tecnico_cotizacion.btn_back') }}
      </a>
    </div>

    @if ($errors->any())
      <div class="alert mb-3 cot-alert-error">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ __('tecnico_cotizacion.msg_validation_error') }}
      </div>
    @endif

    <form action="{{ route('tecnico.cotizacion.store', $viewData['project']->getId()) }}" method="POST"
      id="cotizacionForm">
      @csrf

      <div class="cot-header-card mb-4">
        <p class="cot-project-name">
          <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getNombre() }}
        </p>
        <p class="cot-project-meta">
          <i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCiudad() }} —
          {{ $viewData['project']->getDireccion() }}
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
            <tr id="emptyRow">
              <td colspan="5" class="cot-empty">
                <i class="bi bi-box-seam cot-empty-icon d-block mb-1"></i>
                {{ __('tecnico_cotizacion.msg_add_materials_hint') }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="cot-footer">
        <a href="{{ route('tecnico.cotizacion.index', $viewData['project']->getId()) }}"
          class="um-btn-icon um-btn-icon--edit px-4 py-2">
          {{ __('tecnico_cotizacion.btn_cancel') }}
        </a>
        <button type="submit" class="um-btn-primary px-4 py-2" id="submitBtn">
          <i class="bi bi-send-fill me-1"></i> {{ __('tecnico_cotizacion.btn_send_quote') }}
        </button>
      </div>

    </form>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/tecnico/cotizacion-form.js')
@endpush
