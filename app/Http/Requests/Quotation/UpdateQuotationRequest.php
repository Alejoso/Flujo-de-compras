<?php

namespace App\Http\Requests\Quotation;

use Illuminate\Foundation\Http\FormRequest;

// TODO: update Blade form input names to match new field names (materials, materials.*.presentation_material_type_id, materials.*.quantity)
class UpdateQuotationRequest extends FormRequest
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
            'materials.required' => __('technician_quotation.validation_materials_required'),
            'materials.min' => __('technician_quotation.validation_materials_required'),
            'materials.*.presentation_material_type_id.required' => __('technician_quotation.validation_material_id_required'),
            'materials.*.presentation_material_type_id.exists' => __('technician_quotation.validation_material_id_exists'),
            'materials.*.presentation_material_type_id.distinct' => __('technician_quotation.validation_material_id_distinct'),
            'materials.*.quantity.required' => __('technician_quotation.validation_quantity_required'),
            'materials.*.quantity.numeric' => __('technician_quotation.validation_quantity_numeric'),
            'materials.*.quantity.min' => __('technician_quotation.validation_quantity_min'),
        ];
    }
}
