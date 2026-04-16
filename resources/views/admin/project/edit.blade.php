@extends('layouts.admin')
@section('page-title', __('project.edit_a_project'))

@section('content')
  <div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-folder-plus me-2"></i>{{ __('project.edit_a_project') }}</h1>
      <a href="{{ route('admin.project.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> {{ __('project.back') }}
      </a>
    </div>

    {{-- Form centered --}}
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="um-card">
          <div class="um-card-header">
            <div>
              <p class="um-card-title">{{ __('project.edit_project_name', ['name' => $viewData['project']->getName()]) }}
              </p>
              <p class="um-card-subtitle">{{ __('project.update_info') }}</p>
            </div>
          </div>

          <div class="p-4">
            <form action="{{ route('admin.project.update', ['id' => $viewData['project']->getId()]) }}" method="POST">
              @csrf
              @method('PATCH')

              <div class="row g-3">

                {{-- Name --}}
                <div class="col-12">
                  <label class="form-label">{{ __('project.name') }}</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $viewData['project']->getName()) }}"
                    placeholder="{{ __('project.placeholder_name') }}">
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Address --}}
                <div class="col-12">
                  <label class="form-label">{{ __('project.address') }}</label>
                  <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                    value="{{ old('address', $viewData['project']->getAddress()) }}"
                    placeholder="{{ __('project.placeholder_address') }}">
                  @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- City --}}
                <div class="col-md-6">
                  <label class="form-label">{{ __('project.city') }}</label>
                  <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                    value="{{ old('city', $viewData['project']->getCity()) }}"
                    placeholder="{{ __('project.placeholder_city') }}">
                  @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Total cost --}}
                <div class="col-md-6">
                  <label class="form-label">{{ __('project.total_cost') }}</label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" id="costoTotalFormatted"
                      class="form-control @error('total_cost') is-invalid @enderror"
                      value="{{ old('total_cost', $viewData['project']->getTotalCost() !== null ? number_format($viewData['project']->getTotalCost(), 0, ',', '.') : '') }}"
                      placeholder="{{ __('project.placeholder_cost') }}" inputmode="numeric">
                    <input type="hidden" name="total_cost" id="costoTotalReal"
                      value="{{ old('total_cost', $viewData['project']->getTotalCost()) }}">
                    @error('total_cost')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                {{-- Client --}}
                <div class="col-md-6">
                  <label class="form-label">{{ __('project.client') }}</label>
                  <select name="client_id" class="form-select @error('client_id') is-invalid @enderror">
                    <option value="{{ $viewData['project']->getClient()->getId() }}"
                      {{ old('client_id', $viewData['project']->getClient()->getId()) == $viewData['project']->getClient()->getId() ? 'selected' : '' }}>
                      {{ $viewData['project']->getClient()->getName() }}
                    </option>
                    @foreach ($viewData['clients'] as $client)
                      <option value="{{ $client->getId() }}">
                        {{ $client->getName() }}
                      </option>
                    @endforeach
                  </select>
                  @error('client_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">{{ __('project.client') }}</label>
                  <select name="status" class="form-select @error('status') is-invalid @enderror">
                    @foreach ($viewData['states'] as $state)
                      {{-- Show only the states that are not selected --}}
                      <option value="{{ $state }}"
                        {{ old('status', $viewData['project']->getStatus()) === $state ? 'selected' : '' }}>
                        {{ match ($state) {
                            'Negotiation' => __('project.status_negotiation'),
                            'In Progress' => __('project.status_in_progress'),
                            default => __('project.status_completed'),
                        } }}
                      </option>
                    @endforeach
                  </select>
                  @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

              </div>

              {{-- Actions --}}
              <div class="d-flex justify-content-between align-items-center mt-4">
                {{-- Left side: Delete --}}
                <button type="button" class="um-btn-icon um-btn-icon--delete px-3 py-2" data-bs-toggle="modal"
                  data-bs-target="#deleteProjectModal">
                  <i class="bi bi-trash me-1"></i> {{ __('project.delete') }}
                </button>

                {{-- Right side: Cancel + Save --}}
                <div class="d-flex gap-2">
                  <a href="{{ route('admin.project.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
                    {{ __('project.cancel') }}
                  </a>
                  <button type="submit" class="um-btn-primary">
                    <i class="bi bi-floppy me-1"></i> {{ __('project.edit_project') }}
                  </button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

    {{-- Modal for confirmation on delete --}}
    <div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light border-secondary">
          <div class="modal-header border-secondary">
            <h5 class="modal-title">{{ __('project.confirm_delete_title') }}</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            {{ __('project.confirm_delete', ['name' => $viewData['project']->getName()]) }}
          </div>
          <div class="modal-footer border-secondary">
            <button type="button" class="um-btn-icon um-btn-icon--edit px-3 py-2" data-bs-dismiss="modal">
              {{ __('project.cancel') }}
            </button>
            <form action="{{ route('admin.project.destroy', $viewData['project']->getId()) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="um-btn-icon um-btn-icon--delete px-3 py-2">
                <i class="bi bi-trash me-1"></i> {{ __('project.delete') }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>


    @push('scripts')
      <script src="{{ asset('js/Format/formatMiles.js') }}"></script>
      <script>
        formatMiles('costoTotalFormatted', 'costoTotalReal');
      </script>
    @endpush

  </div>
@endsection
