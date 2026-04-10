<x-mail.layout :title="__('email.reset_password_title')">

    <x-mail.header
        :label="__('email.reset_password_label')"
        :title="__('email.reset_password_title')"
    />

    <x-mail.card :title="__('email.reset_password_card_request')">
        <p class="action-description">
            {{ __('email.reset_password_body', ['name' => $user->name, 'minutes' => config('auth.passwords.users.expire')]) }}
        </p>

        <div class="btn-wrapper">
            <a href="{{ $url }}" class="btn-primary">{{ __('email.reset_password_btn') }}</a>
        </div>

        <p class="link-note">
            {{ __('email.reset_password_link_note') }}<br>
            <a href="{{ $url }}">{{ $url }}</a>
        </p>
    </x-mail.card>

    <x-mail.card :title="__('email.reset_password_card_no_request')">
        <p class="action-description">
            {{ __('email.reset_password_no_request') }}
        </p>
    </x-mail.card>

    <x-mail.footer />

</x-mail.layout>
