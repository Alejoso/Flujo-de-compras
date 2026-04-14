@extends('layouts.admin')
@section('page-title', __('proyecto.new_project'))

@section('content')
  <div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-folder-plus me-2"></i>{{ __('proyecto.new_project') }}</h1>
      <a href="{{ route('admin.project.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
        <i class="bi bi-arrow-left me-1"></i> {{ __('proyecto.back') }}
      </a>
    </div>

    {{-- Form centered --}}
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="um-card">
          <div class="um-card-header">
            <div>
              <p class="um-card-title">{{ __('proyecto.project_info') }}</p>
              <p class="um-card-subtitle">{{ __('proyecto.fill_fields') }}</p>
            </div>
          </div>

          <div class="p-4">
            <form action="{{ route('admin.project.save') }}" method="POST">
              @csrf

              <div class="row g-3">

                {{-- Nombre --}}
                <div class="col-12">
                  <label class="form-label">{{ __('proyecto.name') }}</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="{{ __('proyecto.placeholder_name') }}">
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Dirección --}}
                <div class="col-12">
                  <label class="form-label">{{ __('proyecto.address') }}</label>
                  <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                    value="{{ old('address') }}" placeholder="{{ __('proyecto.placeholder_address') }}">
                  @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Ciudad --}}
                <div class="col-md-6">
                  <label class="form-label">{{ __('proyecto.city') }}</label>
                  <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                    value="{{ old('city') }}" placeholder="{{ __('proyecto.placeholder_city') }}">
                  @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Costo Total --}}
                <div class="col-md-6">
                  <label class="form-label">{{ __('proyecto.total_cost') }}</label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" id="costoTotalFormatted"
                      class="form-control @error('total_cost') is-invalid @enderror"
                      value="{{ old('total_cost') ? number_format(old('total_cost'), 0, ',', '.') : '' }}"
                      placeholder="{{ __('proyecto.placeholder_cost') }}" inputmode="numeric">
                    <input type="hidden" name="total_cost" id="costoTotalReal">
                    @error('total_cost')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                {{-- Cliente --}}
                <div class="col-md-6">
                  <label class="form-label">{{ __('proyecto.client') }}</label>
                  <select name="client_id" class="form-select @error('client_id') is-invalid @enderror">
                    <option value="" disabled selected>{{ __('proyecto.select_client') }}</option>
                    @foreach ($viewData['clients'] as $client)
                      <option value="{{ $client->getId() }}"
                        {{ old('client_id') == $client->getId() ? 'selected' : '' }}>
                        {{ $client->getName() }}
                      </option>
                    @endforeach
                  </select>
                  @error('client_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

              </div>

              {{-- Actions --}}
              <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.project.index') }}" class="um-btn-icon um-btn-icon--edit px-3 py-2">
                  {{ __('proyecto.cancel') }}
                </a>
                <button type="submit" class="um-btn-primary">
                  <i class="bi bi-floppy me-1"></i> {{ __('proyecto.save_project') }}
                </button>
              </div>

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
