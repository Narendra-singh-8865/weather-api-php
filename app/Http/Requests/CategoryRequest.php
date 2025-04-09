<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // You can add additional authorization logic here if needed.
    }

    

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        
        // Get the ID for the update case (null for create case)
        
        
        return [
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'code' => [
                'required',
                'string',
                'max:10',
                // Unique rule with condition for `store_id` and excluding the current category ID during update
                
            ],
            'status' => 'required|in:0,1',
        ];
    }

    /**
     * Get the custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a valid string.',
            'name.max' => 'The category name must not exceed 50 characters.',

            'description.string' => 'The description must be a valid string.',
            'description.max' => 'The description must not exceed 255 characters.',

            'code.required' => 'The category code is required.',
            'code.string' => 'The category code must be a valid string.',
            'code.max' => 'The category code must not exceed 10 characters.',
            

            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either "active" or "inactive".',
        ];
    }
}
