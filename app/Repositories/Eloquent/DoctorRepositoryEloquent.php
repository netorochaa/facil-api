<?php

namespace App\Repositories\Eloquent;

use App\Models\Doctor;
use App\Repositories\IDoctorRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DoctorRepositoryEloquent implements IDoctorRepository
{
    public function store(array $data): Doctor
    {
        return Doctor::create($data);
    }

    public function list(?string $searchByName = null): LengthAwarePaginator
    {
        return Doctor::query()
            ->search($searchByName)
            ->orderBy('name')
            ->paginate(20);
    }
}
