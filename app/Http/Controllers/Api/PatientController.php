<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Resources\PatientResource;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(protected PatientService $patientService) {}

    public function index(Request $request): JsonResponse
    {
        $params = $request->only('nome');

        $cityList = $this->patientService->list($params);

        return PatientResource::collection($cityList)->toResponse($request);
    }

    public function store(PatientStoreRequest $request): JsonResponse
    {
        $patient = $this->patientService->store($request->validated());

        return (new PatientResource($patient))->toResponse($request);
    }

    public function update(PatientStoreRequest $request, int $id): JsonResponse
    {
        $patient = $this->patientService->update($request->all(), $id);

        return (new PatientResource($patient))->toResponse($request);
    }
}
