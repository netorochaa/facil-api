<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentStoreRequest;
use App\Http\Resources\AppointmentResource;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct(protected AppointmentService $appointmentService) {}

    public function index(Request $request): JsonResponse
    {
        $params = $request->only('nome');

        $cityList = $this->appointmentService->list($params);

        return AppointmentResource::collection($cityList)->toResponse($request);
    }

    public function store(AppointmentStoreRequest $request): JsonResponse
    {
        $Appointment = $this->appointmentService->store($request->validated());

        return (new AppointmentResource($Appointment))->toResponse($request);
    }
}
