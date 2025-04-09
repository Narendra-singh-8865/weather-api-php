<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can implement authorization logic if required
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route = $this->route()->getName();

        

        switch ($route) {
            case 'auth.register':
                return [
                    'first_name' => 'required|string|max:25',
                    'last_name' => 'required|string|max:25',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:8',
                    'mobile' => 'required|digits_between:10,10',
                    'store_id' => 'required|integer',
                ];

            case 'auth.login':
                return [
                    'email' => 'required|email',
                    'password' => 'required|string',
                ];

            case 'auth.forgotPassword':
                return [
                    'email' => 'required|email|exists:users,email',
                ];

            default:
                return [];
        }
    }

    /**
     * Custom error messages for validation failures.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 36 characters.',
        
            'email.required' => 'The email address is required.',
            'email.email' => 'The email address must be a valid email.',
            'email.unique' => 'This email address is already registered.',
            'email.exists' => 'The provided email does not exist in our records.',
        
            'password.required' => 'The password is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            
        
            'mobile.required' => 'The mobile number is required.',
            'mobile.digits_between' => 'The mobile number must be 10 digits.',
        
            'store_id.required' => 'The store ID is required.',
            'store_id.integer' => 'The store ID must be an integer.',
        ];
    }
}
