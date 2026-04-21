<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,technician'],
            'id_number' => ['required', 'string', 'max:20', 'unique:users,id_number'],
            'salary' => ['required', 'integer', 'min:0'],
            'phone_number' => ['required', 'string', 'max:20'],
            'receives_notifications' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'email' => 'correo',
            'password' => 'contraseña',
            'role' => 'rol',
            'id_number' => 'cédula',
            'salary' => 'sueldo',
            'phone_number' => 'teléfono',
            'receives_notifications' => 'recibe notificaciones',
        ];
    }
}
