<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Requests\PatientUpdateRequest;
use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientWithAppointmentResource;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(protected PatientService $patientService) {}

    public function index(Request $request): JsonResponse
    {
        $params = $request->only('nome');

        $patientList = $this->patientService->list($params);

        return PatientResource::collection($patientList)->toResponse($request);
    }

    public function store(PatientStoreRequest $request): JsonResponse
    {
        $patient = $this->patientService->store($request->validated());

        return (new PatientResource($patient))->toResponse($request);
    }

    public function update(PatientUpdateRequest $request, int $id): JsonResponse
    {
        $patient = $this->patientService->update($request->validated(), $id);

        return (new PatientResource($patient))->toResponse($request);
    }

    public function byDoctor(Request $request, int $doctorId): JsonResponse
    {
        $params = $request->only(['apenas-agendadas', 'nome']);

        $patientList = $this->patientService->listByDoctor($params, $doctorId);

        return PatientWithAppointmentResource::collection($patientList)->toResponse($request);
    }
}
