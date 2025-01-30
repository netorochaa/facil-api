<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PatientWithAppointmentResource extends PatientResource
{
    public function toArray(Request $request): array
    {
        return array_merge(
            parent::toArray($request),
            ['appointments' => AppointmentResource::collection($this->appointments)]
        );
    }
}
