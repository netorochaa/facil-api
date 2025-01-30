<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'doctor' => new DoctorResource($this->doctor),
            'patient' => new PatientResource($this->patient),
            'date' => $this->date,
        ];
    }
}
