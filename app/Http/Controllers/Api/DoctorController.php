<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorStoreRequest;
use App\Http\Resources\DoctorResource;
use App\Services\DoctorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(protected DoctorService $doctorService) {}

    public function index(Request $request): JsonResponse
    {
        $params = $request->only('nome');

        $cityList = $this->doctorService->list($params);

        return DoctorResource::collection($cityList)->toResponse($request);
    }

    public function store(DoctorStoreRequest $request): JsonResponse
    {
        $doctor = $this->doctorService->store($request->validated());

        return (new DoctorResource($doctor))->toResponse($request);
    }
}
