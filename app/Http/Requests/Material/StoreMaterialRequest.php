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
            'material_mode' => 'required|in:new,existing',
            'material_id' => 'required_if:material_mode,existing|nullable|exists:materials,id',
            'description' => 'required_if:material_mode,new|nullable|string|max:255',

            'types' => 'required|array|min:1',
            'types.*.specification' => 'required|string|max:255',
            'types.*.unit_of_measure_id' => 'nullable|exists:unit_of_measures,id',

            'types.*.presentations' => 'required|array|min:1',
            'types.*.presentations.*.presentation_id' => 'required|exists:presentations,id',
            'types.*.presentations.*.presentation_quantity' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'types.required' => __('material.validation_types_required'),
            'types.*.specification.required' => __('material.validation_type_specification_required'),
            'types.*.presentations.required' => __('material.validation_type_presentations_required'),
            'types.*.presentations.*.presentation_id.required' => __('material.validation_presentation_required'),
            'types.*.presentations.*.presentation_quantity.required' => __('material.validation_presentation_quantity_required'),
            'description.required_if' => __('material.validation_description_required'),
            'material_id.required_if' => __('material.validation_material_required'),
        ];
    }
}
