<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->getRole() === 'admin';
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nit'            => 'required|string|max:255',
            'name'           => 'required|string|max:255',
            'advisor_name'   => 'required|string|max:255',
            'account_number' => 'nullable|string|max:255',
        ];
    }
}
