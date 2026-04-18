@extends('layouts.admin')
@section('page-title', __('technician_quotation.title_versions', ['number' => $viewData['quotationNumber']]))

@push('styles')
  <link href="{{ asset('css/technician.css') }}" rel="stylesheet">
@endpush

@section('content')
  <div class="pj-wrapper">

    <div class="um-header">
      <h1 class="um-title">
        <i class="bi bi-clipboard-data-fill me-2"></i>
        {{ __('technician_quotation.title_index') }} {{ $viewData['quotationNumber'] }}
        <span class="cot-estado-label cot-estado--{{ str_replace(' ', '-', strtolower($viewData['quotation']->getStatus())) }}">
          {{ match ($viewData['quotation']->getStatus()) {
              'Technician' => __('technician_quotation.status_technician'),
              'Technician Edited' => __('technician_quotation.status_technician_edited'),
              'Technician Final' => __('technician_quotation.status_technician_final'),
              'Admin Edited' => __('technician_quotation.status_admin_edited'),
              'In Process' => __('technician_quotation.status_in_process'),
              'Invoiced' => __('technician_quotation.status_invoiced'),
              default => __('technician_quotation.status_cancelled'),
          } }}
        </span>
      </h1>
      <a href="{{ route('admin.project.showQuotations', $viewData['project']->getId()) }}"
        class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> {{ __('technician_quotation.btn_back') }}
      </a>
    </div>

    <div class="cot-header-card mb-4 text-center">
      <p class="cot-project-label mb-1"><i class="bi bi-folder-fill cot-icon-primary me-1"></i>{{ __('technician_quotation.label_project') }}</p>
      <h2 class="cot-project-title mb-2">{{ $viewData['project']->getName() }}</h2>
      <div class="cot-project-details justify-content-center mt-2">
        <span><i class="bi bi-geo-alt me-1"></i>{{ $viewData['project']->getCity() }}, {{ $viewData['project']->getAddress() }}</span>
      </div>
    </div>

    {{-- Technician Final: admin acepta (En Proceso), rechaza (devuelve con correo) o edita --}}
    @if ($viewData['currentVersion'] && $viewData['status'] === 'Technician Final')
      <div class="d-flex justify-content-between mb-3">
        <div class="d-flex gap-2">
          <button type="button"
            class="um-btn-icon um-btn-icon--delete px-3 py-2"
            data-bs-toggle="modal"
            data-bs-target="#rejectModalVersions">
            <i class="bi bi-arrow-counterclockwise me-1"></i> {{ __('project.btn_return_to_technician') }}
          </button>
          <form action="{{ route('admin.quotation.accept', [$viewData['project']->getId(), $viewData['quotation']->getId()]) }}" method="POST">
            @csrf
            <button type="submit" class="um-btn-primary px-3 py-2">
              <i class="bi bi-check-circle me-1"></i> {{ __('project.btn_accept_quotation') }}
            </button>
          </form>
        </div>
        <a href="{{ route('admin.quotation.edit', [$viewData['project']->getId(), $viewData['currentVersion']->getId()]) }}"
          class="um-btn-primary px-4 py-2">
          <i class="bi bi-clipboard-plus me-1"></i> {{ __('technician_quotation.btn_new_version') }}
        </a>
      </div>
    @endif

    {{-- Admin Edited: devuelve al técnico, acepta (En Proceso) o sigue editando --}}
    @if ($viewData['currentVersion'] && $viewData['status'] === 'Admin Edited')
      <div class="d-flex justify-content-between mb-3">
        <div class="d-flex gap-2">
          <button type="button"
            class="um-btn-icon um-btn-icon--delete px-3 py-2"
            data-bs-toggle="modal"
            data-bs-target="#rejectModalVersions">
            <i class="bi bi-arrow-counterclockwise me-1"></i> {{ __('project.btn_return_to_technician') }}
          </button>
          <form action="{{ route('admin.quotation.accept', [$viewData['project']->getId(), $viewData['quotation']->getId()]) }}" method="POST">
            @csrf
            <button type="submit" class="um-btn-primary px-3 py-2">
              <i class="bi bi-check-circle me-1"></i> {{ __('project.btn_accept_quotation') }}
            </button>
          </form>
        </div>
        <a href="{{ route('admin.quotation.edit', [$viewData['project']->getId(), $viewData['currentVersion']->getId()]) }}"
          class="um-btn-primary px-4 py-2">
          <i class="bi bi-clipboard-plus me-1"></i> {{ __('technician_quotation.btn_new_version') }}
        </a>
      </div>
    @endif

    <div class="modal fade" id="rejectModalVersions" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{ __('project.modal_reject_title') }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              {{ __('project.modal_reject_body') }}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                {{ __('project.modal_cancel') }}
              </button>
              <form action="{{ route('admin.quotation.reject', [$viewData['project']->getId(), $viewData['quotation']->getId()]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">
                  {{ __('project.modal_reject_confirm') }}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

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
                {{ $version->getCreatedAt() }}
              </td>
              <td class="cot-td-actions" data-label="{{ __('technician_quotation.th_actions') }}">
                <a href="{{ route('admin.quotation.show', [$viewData['project']->getId(), $version->getId()]) }}"
                  class="um-btn-icon um-btn-icon--edit px-3 py-1">
                  <i class="bi bi-eye me-1"></i> {{ __('technician_quotation.btn_view_detail') }}
                </a>
                @if ($version->getIsMostRecent() && in_array($viewData['quotation']->getStatus(), ['Technician Final', 'Admin Edited']))
                  <a href="{{ route('admin.quotation.edit', [$viewData['project']->getId(), $version->getId()]) }}"
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
