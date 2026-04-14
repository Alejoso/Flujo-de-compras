<?php

namespace App\Http\Requests\Quotation;

use Illuminate\Foundation\Http\FormRequest;

// TODO: update Blade form input names to match new field names (materials, materials.*.presentation_material_type_id, materials.*.quantity)
class StoreQuotationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'materials' => 'required|array|min:1',
            'materials.*.presentation_material_type_id' => 'required|exists:presentation_material_types,id|distinct',
            'materials.*.quantity' => 'required|numeric|min:0.01',
        ];
    }

    public function messages(): array
    {
        return [
            'materials.required' => 'Debes agregar al menos un material.',
            'materials.min' => 'Debes agregar al menos un material.',
            'materials.*.presentation_material_type_id.required' => 'Selecciona un material en cada fila.',
            'materials.*.presentation_material_type_id.exists' => 'Uno de los materiales seleccionados no es válido.',
            'materials.*.presentation_material_type_id.distinct' => 'No puedes agregar la misma combinación de material y presentación más de una vez.',
            'materials.*.quantity.required' => 'Ingresa la cantidad de cada material.',
            'materials.*.quantity.numeric' => 'La cantidad debe ser un número.',
            'materials.*.quantity.min' => 'La cantidad debe ser mayor a 0.',
        ];
    }
}
