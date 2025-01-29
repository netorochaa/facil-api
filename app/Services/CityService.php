<?php

namespace App\Services;

use App\Repositories\ICityRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CityService
{
    public function __construct(
        protected ICityRepository $cityRepository
    ) {}

    public function list(array $params): LengthAwarePaginator
    {
        $searchByName = data_get($params, 'nome');

        return $this->cityRepository->list($searchByName);
    }
}
