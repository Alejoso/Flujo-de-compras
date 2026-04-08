@extends('layouts.admin')
@section('page-title', __('admin_user.title'))

@section('content')
<div class="um-wrapper">

    <div class="um-header">
        <h1 class="um-title"><i class="bi bi-people-fill"></i> {{ __('admin_user.title') }}</h1>
    </div>

    <div class="um-card">
        <div class="um-card-header">
            <div>
                <div class="um-card-title">{{ __('admin_user.list_title') }}</div>
                <div class="um-card-subtitle">{{ __('admin_user.list_subtitle') }}</div>
            </div>
            <a href="{{ route('admin.user.create') }}" class="um-btn-primary">
                <i class="bi bi-plus-lg"></i>
                {{ __('admin_user.btn_create') }}
            </a>
        </div>

        <div class="um-table-wrapper">
            <table class="um-table">
                <thead>
                    <tr>
                        <th>{{ __('admin_user.th_user') }}</th>
                        <th>{{ __('admin_user.th_name') }}</th>
                        <th>{{ __('admin_user.th_email') }}</th>
                        <th>{{ __('admin_user.th_rol') }}</th>
                        <th>{{ __('admin_user.th_cedula') }}</th>
                        <th>{{ __('admin_user.th_phone') }}</th>
                        <th>{{ __('admin_user.th_salary') }}</th>
                        <th>{{ __('admin_user.th_notifications') }}</th>
                        <th>{{ __('admin_user.th_actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($viewData['users'] as $user)
                    <tr class="um-row">
                        <td class="um-td-avatar">
                            <div class="um-user-cell">
                                <div class="um-avatar">
                                    {{ strtoupper(substr($user->getName(), 0, 1)) }}{{ strtoupper(substr(strstr($user->getName(), ' '), 1, 1)) }}
                                </div>
                            </div>
                        </td>
                        <td data-label="{{ __('admin_user.th_name') }}"><span class="um-user-name">{{ $user->getName() }}</span></td>
                        <td data-label="{{ __('admin_user.th_email') }}" class="um-email">{{ $user->getEmail() }}</td>
                        <td data-label="{{ __('admin_user.th_rol') }}">
                            <span class="um-badge um-badge--{{ $user->getRol() }}">
                                {{ ucfirst($user->getRol()) }}
                            </span>
                        </td>
                        <td data-label="{{ __('admin_user.th_cedula') }}">{{ $user->getCedula() }}</td>
                        <td data-label="{{ __('admin_user.th_phone') }}">{{ $user->getNumeroTelefono() }}</td>
                        <td data-label="{{ __('admin_user.th_salary') }}">$ {{ number_format($user->getSueldo(), 0, '', '.') }}</td>
                        <td data-label="{{ __('admin_user.th_notifications') }}">
                            <span class="um-status um-status--{{ $user->getRecibeNotificaciones() ? '1' : '0' }}">
                                {{ $user->getRecibeNotificaciones() ? __('admin_user.yes') : __('admin_user.no') }}
                            </span>
                        </td>
                        <td data-label="{{ __('admin_user.th_actions') }}">
                            <div class="um-actions">
                                <a href="{{ route('admin.user.edit', $user->getId()) }}" class="um-btn-icon um-btn-icon--edit" title="{{ __('admin_user.btn_save_changes') }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('admin.user.destroy', $user->getId()) }}" method="POST" onsubmit="return confirm('{{ __('admin_user.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="um-btn-icon um-btn-icon--delete" title="{{ __('admin_user.th_actions') }}">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="um-empty">{{ __('admin_user.empty') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
