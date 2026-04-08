@extends('layouts.admin')
@section('page-title', __('admin_user.title_edit'))

@section('content')

<div class="um-form-page">
    <div class="um-form-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">{{ __('admin_user.title_edit') }}</h4>
            <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('admin_user.btn_back') }}
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.user.update', $viewData['user']->getId()) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin_user.label_name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $viewData['user']->getName()) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin_user.label_email') }}</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $viewData['user']->getEmail()) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{!! __('admin_user.label_password_edit') !!}</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin_user.label_rol') }}</label>
                        <select name="rol" class="form-select">
                            <option value="admin" {{ old('rol', $viewData['user']->getRol()) === 'admin' ? 'selected' : '' }}>{{ __('admin_user.rol_admin') }}</option>
                            <option value="tecnico" {{ old('rol', $viewData['user']->getRol()) === 'tecnico' ? 'selected' : '' }}>{{ __('admin_user.rol_tecnico') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin_user.label_cedula') }}</label>
                        <input type="text" name="cedula" class="form-control" value="{{ old('cedula', $viewData['user']->getCedula()) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin_user.label_salary') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text"
                                id="sueldoFormatted"
                                class="form-control @error('sueldo') is-invalid @enderror"
                                value="{{ number_format(old('sueldo', $viewData['user']->getSueldo()), 0, ',', '.') }}"
                                placeholder="{{ __('admin_user.label_salary') }}"
                                inputmode="numeric">
                            <input type="hidden"
                                name="sueldo"
                                id="sueldoReal"
                                value="{{ old('sueldo', $viewData['user']->getSueldo()) }}">
                            @error('sueldo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin_user.label_phone') }}</label>
                        <input type="text" name="numeroTelefono" class="form-control" value="{{ old('numeroTelefono', $viewData['user']->getNumeroTelefono()) }}">
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="recibeNotificaciones" class="form-check-input" value="1"
                            {{ old('recibeNotificaciones', $viewData['user']->getRecibeNotificaciones()) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ __('admin_user.label_notifications') }}</label>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">{{ __('admin_user.btn_save_changes') }}</button>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">{{ __('admin_user.btn_cancel') }}</a>
                    </div>

                </form>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="{{ asset('js/Format/formatMiles.js') }}"></script>
        <script>
            formatMiles('sueldoFormatted', 'sueldoReal');
        </script>
    @endpush
    
</div>

@endsection
