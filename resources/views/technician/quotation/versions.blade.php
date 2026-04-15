@extends('layouts.technician')
@section('page-title', __('technician_quotation.title_versions', ['number' => $viewData['quotationNumber']]))

@section('content')
  <div class="pj-wrapper">

    <div class="um-header">
      <h1 class="um-title">
        <i class="bi bi-clipboard-data-fill me-2"></i>
        {{ __('technician_quotation.title_index') }} {{ $viewData['quotationNumber'] }}
        <span
          class="cot-estado-label cot-estado--{{ str_replace(' ', '-', strtolower($viewData['quotation']->getStatus())) }}">{{ match ($viewData['quotation']->getStatus()) {
              'Technician' => __('technician_quotation.status_technician'),
              'Technician Edited' => __('technician_quotation.status_technician_edited'),
              'Pending' => __('technician_quotation.status_pending'),
              'Technician Final' => __('technician_quotation.status_technician_final'),
              'Admin Edited' => __('technician_quotation.status_admin_edited'),
              'In Process' => __('technician_quotation.status_in_process'),
              'Invoiced' => __('technician_quotation.status_invoiced'),
              default => __('technician_quotation.status_cancelled'),
          } }}</span>
      </h1>
      <a href="{{ route('technician.quotation.index', $viewData['project']->getId()) }}"
        class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> {{ __('technician_quotation.btn_back') }}
      </a>
    </div>

    <div class="cot-header-card mb-4">
      <p class="cot-project-name">
        <i class="bi bi-folder-fill cot-icon-primary me-2"></i>{{ $viewData['project']->getName() }}
      </p>
      <p class="cot-project-meta">
        <i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCity() }} — {{ $viewData['project']->getAddress() }}
      </p>
    </div>

    @if ($viewData['currentVersion'] && in_array($viewData['quotation']->getStatus(), ['Technician', 'Technician Edited']))
      <div class="d-flex justify-content-between mb-3">
        <form action="{{ route('technician.quotation.submit', [$viewData['project']->getId(), $viewData['quotation']->getId()]) }}" method="POST">
          @csrf
          <button type="submit" class="um-btn-primary px-4 py-2">
            <i class="bi bi-send-fill me-1"></i> {{ __('technician_quotation.btn_submit_final') }}
          </button>
        </form>
        <a href="{{ route('technician.quotation.edit', [$viewData['project']->getId(), $viewData['currentVersion']->getId()]) }}"
          class="um-btn-primary px-4 py-2">
          <i class="bi bi-clipboard-plus me-1"></i> {{ __('technician_quotation.btn_new_version') }}
        </a>
      </div>
    @endif

    <div class="cot-table-wrap">
      <table class="cot-table cot-versions-table">
        <thead>
          <tr>
            <th>{{ __('technician_quotation.label_version') }}</th>
            <th>{{ __('technician_quotation.label_date') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($viewData['versions'] as $version)
            <tr>
              <td data-label="{{ __('technician_quotation.label_version') }}">
                <span class="cot-version-number">V{{ $version->getVersionNumber() }}</span>
                @if ($version->getIsMostRecent())
                  <span class="cot-counter ms-1">{{ __('technician_quotation.label_current') }}</span>
                @endif
              </td>
              <td class="cot-td-date" data-label="{{ __('technician_quotation.label_date') }}">
                {{ $version->getCreatedAt() }}</td>
              <td class="cot-td-actions" data-label="{{ __('technician_quotation.th_actions') }}">
                <a href="{{ route('technician.quotation.show', [$viewData['project']->getId(), $version->getId()]) }}"
                  class="um-btn-icon um-btn-icon--edit px-3 py-1">
                  <i class="bi bi-eye me-1"></i> {{ __('technician_quotation.btn_view_detail') }}
                </a>
                @if (!$version->getIsMostRecent() && $version->getVersionNumber() !== '1')
                  <a href="{{ route('technician.quotation.pdfView', [$viewData['project']->getId(), $version->getId()]) }}"
                    class="um-btn-icon um-btn-icon--edit px-3 py-1 ms-1">
                    <i class="bi bi-file-earmark-pdf me-1"></i> {{ __('technician_quotation.btn_view_pdf') }}
                  </a>
                @endif
                @if ($version->getIsMostRecent() && in_array($viewData['quotation']->getStatus(), ['Technician', 'Technician Edited']))
                  <a href="{{ route('technician.quotation.edit', [$viewData['project']->getId(), $version->getId()]) }}"
                    class="um-btn-icon um-btn-icon--edit px-3 py-1 ms-1">
                    <i class="bi bi-pencil-square me-1"></i> {{ __('technician_quotation.btn_edit_materials') }}
                  </a>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="cot-empty">
                <i class="bi bi-clipboard-x cot-empty-icon d-block mb-1"></i>
                {{ __('technician_quotation.msg_empty_versiones') }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
@endsection
