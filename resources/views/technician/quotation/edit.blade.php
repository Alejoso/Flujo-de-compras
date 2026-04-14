@extends('layouts.technician')
@section('page-title', __('technician_quotation.title_edit'))

@section('content')
  <div class="pj-wrapper" id="quotation-app" data-search-url="{{ route('technician.materials.search') }}"
    data-row-idx="{{ count($viewData['versionMaterials']) }}" data-has-empty-row="0">

    <div class="um-header">
      <h1 class="um-title">
        <i class="bi bi-pencil-square me-2"></i>
        {{ __('technician_quotation.new_version_from', ['version' => $viewData['version']->getVersionNumber()]) }}
      </h1>
      <a href="{{ route('technician.quotation.show', [$viewData['project']->getId(), $viewData['version']->getId()]) }}"
        class="um-btn-icon um-btn-icon--secondary px-3 py-2">
        <i class="bi bi-x-circle me-1"></i> {{ __('technician_quotation.btn_cancel') }}
      </a>
    </div>

    <form
      action="{{ route('technician.quotation.update', [$viewData['project']->getId(), $viewData['version']->getId()]) }}"
      method="POST">
      @csrf
      @method('PATCH')

      <div class="cot-header-card mb-4">
        <p class="cot-project-name">
          <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getName() }}
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
            @foreach ($viewData['versionMaterials'] as $index => $mat)
              <tr data-id="{{ $mat['ptmId'] }}">
                <td>
                  {{ $mat['description'] }} — {{ $mat['specification'] }}
                  <input type="hidden" name="materials[{{ $index }}][presentation_material_type_id]"
                    value="{{ $mat['ptmId'] }}">
                </td>
                <td>{{ $mat['presentation'] }}</td>
                <td>{{ $mat['unit'] }}</td>
                <td>
                  <input type="number" name="materials[{{ $index }}][quantity]" class="form-control"
                    value="{{ $mat['quantity'] }}" step="1" required>
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
          <i class="bi bi-save me-1"></i> {{ __('technician_quotation.btn_save_version') }}
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/technician/quotation-form.js') }}"></script>
@endpush
