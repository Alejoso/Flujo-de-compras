<?php

namespace App\Http\Requests\Material;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'material_mode'                              => 'required|in:new,existing',
            'material_id'                                => 'required_if:material_mode,existing|nullable|exists:materiales,id',
            'descripcion'                                => 'required_if:material_mode,new|nullable|string|max:255',

            'tipos'                                      => 'required|array|min:1',
            'tipos.*.especificacion'                     => 'required|string|max:255',
            'tipos.*.unidadMedidaId'                     => 'nullable|exists:unidad_medidas,id',

            'tipos.*.presentaciones'                     => 'required|array|min:1',
            'tipos.*.presentaciones.*.presentacionId'    => 'required|exists:presentaciones,id',
            'tipos.*.presentaciones.*.cantidadPresentacion' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'tipos.required'                                    => 'Debe agregar al menos un tipo.',
            'tipos.*.especificacion.required'                   => 'La especificación del tipo es obligatoria.',
            'tipos.*.presentaciones.required'                   => 'Cada tipo debe tener al menos una presentación.',
            'tipos.*.presentaciones.*.presentacionId.required'  => 'Seleccione una presentación.',
            'tipos.*.presentaciones.*.cantidadPresentacion.required' => 'La cantidad por presentación es obligatoria.',
            'descripcion.required_if'                           => 'La descripción del material es obligatoria.',
            'material_id.required_if'                           => 'Seleccione un material existente.',
        ];
    }
}