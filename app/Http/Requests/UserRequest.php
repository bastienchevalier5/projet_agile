<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules['name'] = 'required|string|max:100';
        $rules['email'] = 'required|email:rfc,dns';

        return $rules;
    }

    /**
     * Summary of messages
     *
     * @return array<string>
     */
    public function messages()
    {
        return [

        ];
    }
}
