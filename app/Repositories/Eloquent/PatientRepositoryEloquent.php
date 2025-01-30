<?php

namespace App\Repositories\Eloquent;

use App\Models\Patient;
use App\Repositories\IPatientRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientRepositoryEloquent implements IPatientRepository
{
    public function update(array $data, int $id): void
    {
        Patient::where('id', $id)->update($data);
    }

    public function find(int $id): Patient
    {
        return Patient::find($id);
    }

    public function store(array $data): Patient
    {
        return Patient::create($data);
    }

    public function list(?string $searchByName = null): LengthAwarePaginator
    {
        return Patient::query()
            ->search($searchByName)
            ->orderBy('name')
            ->paginate(20);
    }
}
