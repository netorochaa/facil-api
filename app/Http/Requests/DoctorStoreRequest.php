<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'specialty' => ['required', 'string', 'max:255'],
            'city_id' => ['required', 'exists:cities,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'specialty.required' => 'O campo especialidade é obrigatório.',
            'specialty.string' => 'O campo especialidade deve ser uma string.',
            'specialty.max' => 'O campo especialidade não pode ter mais de 255 caracteres.',
            'city_id.required' => 'O campo cidade é obrigatório.',
            'city_id.exists' => 'A cidade fornecida não existe.',
        ];
    }
}
