<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Product2Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required',
            'price_after_discount' => 'required|numeric',
            'original_quantity' => 'required|integer',
            'current_orders' => 'required|integer',
            'current_quantity' => 'required|integer',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'status' => 'required|in:0,1',
            'number_of_review' => 'required|integer',
            'rating' => 'required|numeric|min:0|max:5',
            'discount' => 'nullable|numeric|min:0|max:99', 
        ];
    }
    
}
