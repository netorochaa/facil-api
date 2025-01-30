<?php

namespace App\Services;

use App\Models\Doctor;
use App\Repositories\IDoctorRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class DoctorService
{
    public function __construct(protected IDoctorRepository $repository) {}

    public function list(array $params): LengthAwarePaginator
    {
        $searchByName = data_get($params, 'nome');

        if ($searchByName) {
            $searchByName = Str::removeDoctorPrefix($searchByName);
        }

        return $this->repository->list($searchByName);
    }

    public function listByCity(array $params, int $cityId): LengthAwarePaginator
    {
        $searchByName = data_get($params, 'nome');

        if ($searchByName) {
            $searchByName = Str::removeDoctorPrefix($searchByName);
        }

        return $this->repository->listByCity($cityId, $searchByName);
    }

    public function store(array $data): Doctor
    {
        return $this->repository->store($data);
    }
}
