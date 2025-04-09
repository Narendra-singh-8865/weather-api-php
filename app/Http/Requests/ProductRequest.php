<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('product');
        
        return [
            'name' => 'required|string|max:255',
            'sku' => [
                'required',
                'string',
                'max:50',
                'unique:products,sku,' . $id . ',id,store_id,' . store_id()
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'qr_code' => [
                'required',
                'string',
                'max:100',
                'unique:products,qr_code,' . $id . ',id,store_id,' . store_id()
            ],
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'name.max' => 'The product name must not exceed 255 characters.',
            'sku.required' => 'The SKU is required.',
            'sku.unique' => 'This SKU is already in use.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price cannot be negative.',
            'stock.required' => 'The stock quantity is required.',
            'stock.integer' => 'The stock must be a whole number.',
            'stock.min' => 'The stock cannot be negative.',
            'qr_code.required' => 'The QR code is required.',
            'qr_code.unique' => 'This QR code is already in use.',
            'status.required' => 'The status is required.',
            'status.in' => 'Invalid status value.',
        ];
    }
}
