<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
            // 'email' => 'required|email',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'email.required' => 'Email is required',
            // 'email.email' => 'Please profide the valid email address',
            'name.required' => 'Name is required',
            'id.required' => 'User id is required'
        ];
    }
}
