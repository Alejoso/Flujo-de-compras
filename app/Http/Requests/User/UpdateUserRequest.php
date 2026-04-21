<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'name'                   => ['required', 'string', 'max:255'],
            'email'                  => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password'               => ['nullable', 'string', 'min:8'],
            'role'                   => ['required', 'in:admin,technician'],
            'id_number'              => ['required', 'string', 'max:20', Rule::unique('users', 'id_number')->ignore($userId)],
            'salary'                 => ['required', 'integer', 'min:0'],
            'phone_number'           => ['required', 'string', 'max:20'],
            'receives_notifications' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'                   => 'nombre',
            'email'                  => 'correo',
            'password'               => 'contraseña',
            'role'                   => 'rol',
            'id_number'              => 'cédula',
            'salary'                 => 'sueldo',
            'phone_number'           => 'teléfono',
            'receives_notifications' => 'recibe notificaciones',
        ];
    }
}
