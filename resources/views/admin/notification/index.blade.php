@extends('layouts.admin')
@section('page-title', __('notificacion.notifications'))

@section('content')
  <div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
      <h1 class="um-title"><i class="bi bi-bell-fill"></i> {{ __('notificacion.notification_management') }}</h1>
    </div>

    {{-- Card --}}
    <div class="um-card">
      <div class="um-card-header">
        <div>
          <div class="um-card-title">{{ __('notificacion.people_to_notify') }}</div>
          <div class="um-card-subtitle">{{ __('notificacion.manage_users_subtitle') }}</div>
        </div>
        <a href="#" class="um-btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">
          <i class="bi bi-plus-lg"></i>
          {{ __('notificacion.add_user') }}
        </a>
      </div>

      {{-- Table --}}
      <div class="um-table-wrapper">
        <table class="um-table">
          <thead>
            <tr>
              <th>{{ __('notificacion.user') }}</th>
              <th>{{ __('notificacion.name') }}</th>
              <th>{{ __('notificacion.email') }}</th>
              <th>{{ __('notificacion.role') }}</th>
              <th>{{ __('notificacion.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($viewData['userWithNotifications'] as $user)
              <tr class="um-row">
                <td class="um-td-avatar">
                  <div class="um-user-cell">
                    <div class="um-avatar">
                      {{ strtoupper(substr($user->getName(), 0, 1)) }}{{ strtoupper(substr(strstr($user->getName(), ' '), 1, 1)) }}
                    </div>
                  </div>
                </td>
                <td data-label="{{ __('notificacion.name') }}">
                  <span class="um-user-name">{{ $user->getName() }}</span>
                </td>
                <td data-label="{{ __('notificacion.email') }}" class="um-email">{{ $user->getEmail() }}</td>
                <td data-label="{{ __('notificacion.role') }}">
                  <span class="um-badge um-badge--{{ $user->getRole() }}">
                    {{ match ($user->getRole()) {
                        'admin' => __('admin_user.rol_admin'),
                        'technician' => __('admin_user.rol_tecnico'),
                        'tecnico' => __('admin_user.rol_tecnico'),
                        default => $user->getRole(),
                    } }}
                  </span>
                </td>
                <td data-label="{{ __('notificacion.actions') }}">
                  <form action="{{ route('admin.notification.destroy', ['id' => $user->getId()]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="um-btn-delete" title="{{ __('notificacion.delete') }}">
                      <i class="bi bi-trash me-1"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="um-empty">{{ __('notificacion.no_users') }}</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalAgregarUsuario" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">{{ __('notificacion.add_user') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form action="{{ route('admin.notification.save') }}" method="POST">
          @csrf
          @method('PATCH')
          @if (count($viewData['usersWithNoNotifications']) == 0)
            <div class="modal-body">
              <label class="form-label">{{ __('notificacion.no_users_available') }}</label>
            </div>
          @else
            <div class="modal-body">
              <label class="form-label">{{ __('notificacion.select_user') }}</label>
              <select name="user_id" class="form-select">
                <option value="">{{ __('notificacion.select_user_placeholder') }}</option>
                @foreach ($viewData['usersWithNoNotifications'] as $user)
                  <option value="{{ $user->getId() }}">{{ $user->getName() }} — {{ $user->getEmail() }}</option>
                @endforeach
              </select>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">{{ __('notificacion.cancel') }}</button>
              <button type="submit" class="btn btn-primary">{{ __('notificacion.add') }}</button>
            </div>
          @endif
        </form>

      </div>
    </div>
  </div>
@endsection
