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
            'types.*.type_mode' => 'required|in:new,existing',
            'types.*.type_id' => 'required_if:types.*.type_mode,existing|nullable|exists:types,id',
            'types.*.specification' => 'required_if:types.*.type_mode,new|nullable|string|max:255',
            'types.*.unit_mode' => 'nullable|in:new,existing',
            'types.*.unit_of_measure_id' => 'nullable|exists:unit_of_measures,id',
            'types.*.unit_name' => 'required_if:types.*.unit_mode,new|nullable|string|max:100',
            'types.*.unit_abbreviation' => 'required_if:types.*.unit_mode,new|nullable|string|max:20',

            'types.*.presentations' => 'required|array|min:1',
            'types.*.presentations.*.presentation_mode' => 'required|in:new,existing',
            'types.*.presentations.*.presentation_id' => 'required_if:types.*.presentations.*.presentation_mode,existing|nullable|exists:presentations,id',
            'types.*.presentations.*.presentation_name' => 'required_if:types.*.presentations.*.presentation_mode,new|nullable|string|max:255',
            'types.*.presentations.*.presentation_quantity' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'types.required' => __('material.validation_types_required'),
            'types.*.type_mode.required' => __('material.validation_type_mode_required'),
            'types.*.specification.required_if' => __('material.validation_type_specification_required'),
            'types.*.type_id.required_if' => __('material.validation_type_id_required'),
            'types.*.presentations.required' => __('material.validation_type_presentations_required'),
            'types.*.presentations.*.presentation_mode.required' => __('material.validation_presentation_mode_required'),
            'types.*.presentations.*.presentation_id.required_if' => __('material.validation_presentation_required'),
            'types.*.presentations.*.presentation_name.required_if' => __('material.validation_presentation_name_required'),
            'types.*.presentations.*.presentation_quantity.required' => __('material.validation_presentation_quantity_required'),
            'types.*.unit_name.required_if' => __('material.validation_unit_name_required'),
            'types.*.unit_abbreviation.required_if' => __('material.validation_unit_abbreviation_required'),
            'description.required_if' => __('material.validation_description_required'),
            'material_id.required_if' => __('material.validation_material_required'),
        ];
    }
}
