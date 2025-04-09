<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        return [
            // Validation rules for the title
            'title' => 'required|string|max:50',

            // Validation rules for the email
            'email' => 'required|email|max:50',

            // Validation rules for the message
            'message' => 'required|string|max:1000',
        ];
    }

    /**
     * Get the custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title must not exceed 255 characters.',

            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not exceed 255 characters.',

            'message.required' => 'The message is required.',
            'message.string' => 'The message must be a valid string.',
            'message.max' => 'The message must not exceed 1000 characters.',
        ];
    }
}
