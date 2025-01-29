<?php

namespace App\Services;

use App\Repositories\IDoctorRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DoctorService
{
    public function __construct(protected IDoctorRepository $repository) {}

    public function list(array $params): LengthAwarePaginator
    {
        $searchByName = data_get($params, 'nome');

        if ($searchByName) {
            $searchByName = str_replace(['dr', 'dra', 'Dr', 'Dra'], '', $searchByName);
        }

        return $this->repository->list($searchByName);
    }
}
