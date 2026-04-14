@extends('layouts.technician')
@section('page-title', __('technician_quotation.title_show'))

@section('content')
  <div class="pj-wrapper">

    <div class="um-header">
      <h1 class="um-title">
        <i class="bi bi-clipboard-check-fill me-2"></i>
        {{ __('technician_quotation.label_version') }} {{ $viewData['version']->getVersionNumber() }}
        @if ($viewData['version']->getIsMostRecent())
          <span class="cot-counter ms-2">{{ __('technician_quotation.label_current') }}</span>
        @endif
      </h1>
      <div class="d-flex gap-2">
        <a href="{{ route('technician.quotation.versions', [$viewData['project']->getId(), $viewData['version']->getQuotation()->getId()]) }}"
          class="um-btn-icon um-btn-icon--secondary px-3 py-2">
          <i class="bi bi-arrow-left me-1"></i> {{ __('technician_quotation.btn_back') }}
        </a>

        @if ($viewData['version']->getIsMostRecent())
          <a href="{{ route('technician.quotation.edit', [$viewData['project']->getId(), $viewData['version']->getId()]) }}"
            class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-pencil-square me-1"></i> {{ __('technician_quotation.btn_edit_materials') }}
          </a>
        @endif
      </div>
    </div>

    <div class="cot-header-card mb-4">
      <p class="cot-project-name">
        <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getName() }}
      </p>
      <p class="cot-project-meta">
        <i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCity() }} —
        {{ $viewData['project']->getAddress() }}
        &nbsp;·&nbsp;
        <i class="bi bi-calendar3 me-1"></i>{{ $viewData['version']->getCreatedAt() }}
      </p>
    </div>

    <div class="cot-table-wrap">
      <table class="cot-table cot-show-table">
        <thead>
          <tr>
            <th class="cot-col-show-material">{{ __('technician_quotation.th_material') }}</th>
            <th class="cot-col-show-type">{{ __('technician_quotation.th_type_spec') }}</th>
            <th>{{ __('technician_quotation.label_presentation') }}</th>
            <th class="cot-col-show-unit">{{ __('technician_quotation.label_unit') }}</th>
            <th class="cot-col-show-quantity">{{ __('technician_quotation.label_quantity') }}</th>
          </tr>
        </thead>
        <tbody>
          @forelse($viewData['versionMaterials'] as $mat)
            <tr>
              <td class="cot-td-material" data-label="{{ __('technician_quotation.th_material') }}">
                {{ $mat['description'] }}</td>
              <td class="cot-td-type" data-label="{{ __('technician_quotation.th_type_spec') }}">
                {{ $mat['specification'] }}</td>
              <td data-label="{{ __('technician_quotation.label_presentation') }}">{{ $mat['presentation'] }}</td>
              <td class="cot-td-unit" data-label="{{ __('technician_quotation.label_unit') }}">
                {{ $mat['unit'] ?: '—' }}</td>
              <td class="cot-td-quantity" data-label="{{ __('technician_quotation.label_quantity') }}">
                {{ number_format($mat['quantity'], 2) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="cot-empty">{{ __('technician_quotation.msg_empty_materials') }}</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
@endsection
