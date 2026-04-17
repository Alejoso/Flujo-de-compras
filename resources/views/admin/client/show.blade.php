@extends('layouts.admin')
@section('page-title', $viewData['client']->getName())

@section('content')
  <div class="pj-wrapper">

    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-person-vcard-fill"></i> {{ $viewData['client']->getName() }}</h1>
      <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.client.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
          <i class="bi bi-arrow-left me-1"></i> {{ __('client.back') }}
        </a>
        <a href="{{ route('admin.client.edit', ['id' => $viewData['client']->getId()]) }}"
          class="um-btn-icon um-btn-icon--edit px-3 py-2">
          <i class="bi bi-pencil-fill me-1"></i> {{ __('client.edit') }}
        </a>
      </div>
    </div>

    <div class="um-card mb-4">
      <div class="um-card-header">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-person-badge pj-header-icon"></i>
          <h2 class="um-card-title um-card-title--sm">{{ __('client.client_info') }}</h2>
        </div>
      </div>

      <div class="row g-4 p-4">
        <div class="col-md-6">
          <p class="pj-field-label">{{ __('client.name') }}</p>
          <p class="pj-field-value">{{ $viewData['client']->getName() }}</p>
        </div>
        <div class="col-md-6">
          <p class="pj-field-label">{{ __('client.cedula') }}</p>
          <p class="pj-field-value">{{ $viewData['client']->getIdNumber() ?? __('client.null_data') }}</p>
        </div>
        <div class="col-md-6">
          <p class="pj-field-label">{{ __('client.email') }}</p>
          <p class="pj-field-value">{{ $viewData['client']->getEmail() ?? __('client.null_data') }}</p>
        </div>
        <div class="col-md-6">
          <p class="pj-field-label">{{ __('client.phone') }}</p>
          <p class="pj-field-value">{{ $viewData['client']->getPhone() ?? __('client.null_data') }}</p>
        </div>
      </div>
    </div>

    <div class="um-card">
      <div class="um-card-header">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-folder-fill pj-header-icon"></i>
          <h2 class="um-card-title um-card-title--sm">{{ __('project.projects') }}</h2>
        </div>
      </div>

      <div class="p-4">
        @forelse($viewData['client']->getProjects() as $project)
          <div class="pj-card mb-3">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
              <div>
                <h3 class="pj-title mb-2">{{ $project->getName() }}</h3>
                <div class="text-white-50 mb-1">{{ __('project.address') }}: {{ $project->getAddress() }}</div>
                <div class="text-white-50">{{ __('project.city') }}: {{ $project->getCity() }}</div>
              </div>

              <span
                class="pj-badge pj-badge--{{ match ($project->getStatus()) {'Negotiation' => 'negociacion','In Progress' => 'ejecucion',default => 'finalizado'} }}">
                {{ match ($project->getStatus()) {
                    'Negotiation' => __('project.status_negotiation'),
                    'In Progress' => __('project.status_in_progress'),
                    default => __('project.status_completed'),
                } }}
              </span>
            </div>

            <div class="mt-3 d-flex gap-2 flex-wrap">
              <a href="{{ route('admin.project.show', ['id' => $project->getId()]) }}"
                class="um-btn-icon um-btn-icon--view px-3 py-2">
                <i class="bi bi-eye me-1"></i> {{ __('project.view_details') }}
              </a>
              <a href="{{ route('admin.project.showQuotations', ['id' => $project->getId()]) }}"
                class="um-btn-icon um-btn-icon--edit px-3 py-2">
                <i class="bi bi-receipt me-1"></i> {{ __('project.view_quotations') }}
              </a>
            </div>
          </div>
        @empty
          <div class="um-empty">
            <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
            {{ __('project.no_projects') }}
          </div>
        @endforelse
      </div>
    </div>

  </div>
@endsection
