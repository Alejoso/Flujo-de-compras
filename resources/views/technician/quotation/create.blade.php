@extends('layouts.technician')
@section('page-title', __('technician_quotation.title_create'))

@section('content')
  <div class="pj-wrapper" id="quotation-app"
    data-search-url="{{ route('technician.materials.search') }}"
    data-row-idx="0"
    data-has-empty-row="1"
    data-msg-select-material="{{ __('technician_quotation.msg_select_material_first') }}"
    data-msg-no-results="{{ __('technician_quotation.msg_no_results') }}"
    data-msg-select-presentation="{{ __('technician_quotation.msg_select_presentation') }}"
    data-msg-duplicate="{{ __('technician_quotation.msg_duplicate_material') }}"
    data-msg-no-materials="{{ __('technician_quotation.msg_no_materials') }}">

    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-clipboard-plus me-2"></i>{{ __('technician_quotation.title_create') }}</h1>
      <a href="{{ route('technician.quotation.index', $viewData['project']->getId()) }}"
        class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> {{ __('technician_quotation.btn_back') }}
      </a>
    </div>

    @if ($errors->any())
      <div class="alert mb-3 cot-alert-error">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ __('technician_quotation.msg_validation_error') }}
      </div>
    @endif

    <form action="{{ route('technician.quotation.store', $viewData['project']->getId()) }}" method="POST"
      id="quotationForm">
      @csrf

      <div class="cot-header-card mb-4">
        <p class="cot-project-name">
          <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getName() }}
        </p>
        <p class="cot-project-meta">
          <i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCity() }} —
          {{ $viewData['project']->getAddress() }}
        </p>

        <div class="row mt-3 g-2 align-items-end">
          <div class="col-md-4">
            <label class="form-label fw-bold">{{ __('technician_quotation.label_material') }}</label>
            <div class="ac-wrap">
              <input type="text" id="material-search" class="form-control"
                placeholder="{{ __('technician_quotation.msg_search_placeholder') }}" autocomplete="off">
              <div id="autocomplete-list" class="ac-dropdown"></div>
            </div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold">{{ __('technician_quotation.label_presentation') }}</label>
            <select id="presentation-select" class="form-select" disabled>
              <option value="">{{ __('technician_quotation.msg_select_material_first') }}</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label fw-bold">{{ __('technician_quotation.label_unit') }}</label>
            <input type="text" id="display-unit" class="form-control" readonly placeholder="—">
          </div>
          <div class="col-md-3">
            <button type="button" id="btn-add-material" class="btn btn-primary w-100" disabled>
              <i class="bi bi-plus-lg me-1"></i> {{ __('technician_quotation.btn_add_material') }}
            </button>
          </div>
        </div>
      </div>

      <div class="cot-table-wrap">
        <table class="cot-table cot-edit-table" id="materials-table">
          <thead>
            <tr>
              <th>{{ __('technician_quotation.th_material_spec') }}</th>
              <th>{{ __('technician_quotation.label_presentation') }}</th>
              <th>{{ __('technician_quotation.label_unit') }}</th>
              <th class="col-quantity">{{ __('technician_quotation.label_quantity') }}</th>
              <th class="col-actions"></th>
            </tr>
          </thead>
          <tbody id="materials-list">
            <tr id="emptyRow">
              <td colspan="5" class="cot-empty">
                <i class="bi bi-box-seam cot-empty-icon d-block mb-1"></i>
                {{ __('technician_quotation.msg_add_materials_hint') }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="cot-footer">
        <a href="{{ route('technician.quotation.index', $viewData['project']->getId()) }}"
          class="um-btn-icon um-btn-icon--edit px-4 py-2">
          {{ __('technician_quotation.btn_cancel') }}
        </a>
        <button type="submit" class="um-btn-primary px-4 py-2" id="submitBtn">
          <i class="bi bi-send-fill me-1"></i> {{ __('technician_quotation.btn_send_quote') }}
        </button>
      </div>

    </form>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/technician/quotation-form.js') }}"></script>
@endpush
