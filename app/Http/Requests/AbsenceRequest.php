<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsenceRequest extends FormRequest
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
        $rules['debut'] = 'required|date|before:fin';
        $rules['fin'] = 'required|date|after:debut';
        $rules['motif_id'] = 'required|exists:motifs,id';
        $rules['user_id'] = 'sometimes|exists:users,id';

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
