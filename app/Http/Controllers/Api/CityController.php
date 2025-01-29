<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Services\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(protected CityService $cityService) {}

    public function index(Request $request): JsonResponse
    {
        $params = $request->only('nome');

        $cityList = $this->cityService->list($params);

        return CityResource::collection($cityList)->toResponse($request);
    }
}
