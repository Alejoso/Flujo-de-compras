@extends('layouts.tecnico')
@section('page-title', __('tecnico_cotizacion.title_show'))

@section('content')
  <div class="pj-wrapper">

    <div class="um-header">
      <h1 class="um-title">
        <i class="bi bi-clipboard-check-fill me-2"></i>
        {{ __('tecnico_cotizacion.label_version') }} {{ $viewData['version']->getVersionNumber() }}
        @if ($viewData['version']->getIsMostRecent())
          <span class="cot-counter ms-2">{{ __('tecnico_cotizacion.label_current') }}</span>
        @endif
      </h1>
      <div class="d-flex gap-2">
        <a href="{{ route('technician.quotation.versions', [$viewData['project']->getId(), $viewData['version']->getQuotation()->getId()]) }}"
          class="um-btn-icon um-btn-icon--secondary px-3 py-2">
          <i class="bi bi-arrow-left me-1"></i> {{ __('tecnico_cotizacion.btn_back') }}
        </a>

        @if ($viewData['version']->getIsMostRecent())
          <a href="{{ route('technician.quotation.edit', [$viewData['project']->getId(), $viewData['version']->getId()]) }}"
            class="um-btn-icon um-btn-icon--edit px-3 py-2">
            <i class="bi bi-pencil-square me-1"></i> {{ __('tecnico_cotizacion.btn_edit_materials') }}
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
            <th class="cot-col-show-material">{{ __('tecnico_cotizacion.th_material') }}</th>
            <th class="cot-col-show-tipo">{{ __('tecnico_cotizacion.th_type_spec') }}</th>
            <th>{{ __('tecnico_cotizacion.label_presentation') }}</th>
            <th class="cot-col-show-unidad">{{ __('tecnico_cotizacion.label_unit') }}</th>
            <th class="cot-col-show-cantidad">{{ __('tecnico_cotizacion.label_quantity') }}</th>
          </tr>
        </thead>
        <tbody>
          @forelse($viewData['versionMaterials'] as $mat)
            <tr>
              <td class="cot-td-material" data-label="{{ __('tecnico_cotizacion.th_material') }}">
                {{ $mat['descripcion'] }}</td>
              <td class="cot-td-tipo" data-label="{{ __('tecnico_cotizacion.th_type_spec') }}">
                {{ $mat['especificacion'] }}</td>
              <td data-label="{{ __('tecnico_cotizacion.label_presentation') }}">{{ $mat['presentacion'] }}</td>
              <td class="cot-td-unidad" data-label="{{ __('tecnico_cotizacion.label_unit') }}">
                {{ $mat['unidad'] ?: '—' }}</td>
              <td class="cot-td-cantidad" data-label="{{ __('tecnico_cotizacion.label_quantity') }}">
                {{ number_format($mat['cantidad'], 2) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="cot-empty">{{ __('tecnico_cotizacion.msg_empty_materials') }}</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
@endsection
