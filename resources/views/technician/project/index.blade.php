@extends('layouts.technician')
@section('page-title', __('project.projects'))

@section('content')
  <div class="pj-wrapper">

    {{-- Header --}}
    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-folder-fill me-2"></i>{{ __('project.projects') }}</h1>
    </div>

    {{-- Search & Filters --}}
    <div class="um-card mb-4">
      <div class="um-card-header">
        <form method="GET" action="{{ route('technician.project.index') }}"
          class="d-flex gap-2 flex-wrap align-items-center w-100">
          @if ($viewData['status'])
            <input type="hidden" name="status" value="{{ $viewData['status'] }}">
          @endif
          <div class="input-group search-group">
            <button type="submit" class="input-group-text border-0 bg-transparent"><i class="bi bi-search"></i></button>
            <input type="text" name="search" value="{{ $viewData['search'] }}" class="form-control"
              placeholder="{{ __('project.search_projects') }}">
          </div>
          <div class="d-flex gap-2 ms-auto flex-wrap">
            <a href="{{ request()->fullUrlWithQuery(['status' => '', 'page' => null]) }}"
              class="{{ $viewData['status'] === '' ? 'um-btn-primary' : 'um-btn-filter' }}">
              {{ __('project.all') }}
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'Negotiation', 'page' => null]) }}"
              class="{{ $viewData['status'] === 'Negotiation' ? 'um-btn-primary' : 'um-btn-filter' }}">
              {{ __('project.in_negotiation') }}
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'In Progress', 'page' => null]) }}"
              class="{{ $viewData['status'] === 'In Progress' ? 'um-btn-primary' : 'um-btn-filter' }}">
              {{ __('project.in_progress') }}
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'Completed', 'page' => null]) }}"
              class="{{ $viewData['status'] === 'Completed' ? 'um-btn-primary' : 'um-btn-filter' }}">
              {{ __('project.finished') }}
            </a>
          </div>
        </form>
      </div>
    </div>

    {{-- Project cards grid --}}
    <div class="row g-4">
      @forelse($viewData['projects'] as $project)
        <div class="col-md-6 col-xl-4">
          <div class="pj-card">

            {{-- Title and status --}}
            <div class="d-flex justify-content-between align-items-start mb-1">
              <h5 class="pj-title">{{ $project->getName() }}</h5>
              <span
                class="pj-badge pj-badge--{{ match ($project->getStatus()) {'Negotiation' => 'negociacion','In Progress' => 'ejecucion',default => 'finalizado'} }}">
                {{ match ($project->getStatus()) {
                    'Negotiation' => __('project.status_negotiation'),
                    'In Progress' => __('project.status_in_progress'),
                    default => __('project.status_completed'),
                } }}
              </span>
            </div>

            {{-- Location --}}
            <p class="pj-location">
              <i class="bi bi-geo-alt me-1"></i>
              {{ $project->getCity() }} — {{ $project->getAddress() }}
            </p>

            {{-- Buttons --}}
            <div class="mt-auto d-flex gap-2">
              <a href="{{ route('technician.quotation.index', $project->getId()) }}"
                class="um-btn-icon um-btn-icon--edit flex-fill d-flex justify-content-center py-2">
                <i class="bi bi-clipboard-data me-1"></i> {{ __('project.view_quotations_short') }}
              </a>
              <a href="{{ route('technician.quotation.create', $project->getId()) }}"
                class="um-btn-primary flex-fill d-flex justify-content-center py-2">
                <i class="bi bi-clipboard-plus me-1"></i> {{ __('project.new') }}
              </a>
            </div>

          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="um-empty">
            <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
            {{ __('project.no_projects') }}
          </div>
        </div>
      @endforelse
    </div>

    {{-- Pagination --}}
    @if ($viewData['projects']->hasPages())
      <div class="d-flex justify-content-center mt-4">
        {{ $viewData['projects']->links() }}
      </div>
    @endif

  </div>
@endsection
