<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'numeric', 'digits:11'],
            'phone' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.numeric' => 'O campo CPF deve ser numérico.',
            'cpf.digits' => 'O campo CPF deve ter 11 dígitos.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'phone.string' => 'O campo telefone deve ser uma string.',
            'phone.max' => 'O campo telefone não pode ter mais de 255 caracteres.',
        ];
    }
}
