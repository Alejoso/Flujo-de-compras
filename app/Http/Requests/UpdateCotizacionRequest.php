<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCotizacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'materiales' => 'required|array|min:1',
            'materiales.*.tipoMaterialId' => 'required|exists:tipo_materiales,id|distinct',
            'materiales.*.cantidad' => 'required|numeric|min:0.01',
        ];
    }

    public function messages(): array
    {
        return [
            'materiales.required' => 'Debes agregar al menos un material.',
            'materiales.min' => 'Debes agregar al menos un material.',
            'materiales.*.tipoMaterialId.required' => 'Selecciona un material en cada fila.',
            'materiales.*.tipoMaterialId.exists' => 'Uno de los materiales seleccionados no es válido.',
            'materiales.*.tipoMaterialId.distinct' => 'No puedes agregar el mismo material más de una vez.',
            'materiales.*.cantidad.required' => 'Ingresa la cantidad de cada material.',
            'materiales.*.cantidad.numeric' => 'La cantidad debe ser un número.',
            'materiales.*.cantidad.min' => 'La cantidad debe ser mayor a 0.',
        ];
    }
}
