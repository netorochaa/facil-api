<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'exists:doctors,id'],
            'patient_id' => ['required', 'exists:patients,id'],
            'date' => ['required', Rule::date()->format('Y-m-d H:i:s')],
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required' => 'O campo médico é obrigatório.',
            'doctor_id.exists' => 'O médico fornecido não existe.',
            'patient_id.required' => 'O campo paciente é obrigatório.',
            'patient_id.exists' => 'O paciente fornecido não existe.',
            'date.required' => 'O campo data é obrigatório.',
            'date.date' => 'O campo data deve ser uma data válida.',
        ];
    }
}
