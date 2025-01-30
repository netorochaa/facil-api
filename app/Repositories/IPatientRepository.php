<?php

namespace App\Repositories;

use App\Models\Patient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IPatientRepository
{
    public function list(?string $searchByName = null): LengthAwarePaginator;

    public function store(array $data): Patient;

    public function update(array $data, int $id): void;

    public function find(int $id): Patient;

    public function listByDoctor(int $doctorId, bool $onlyPendingAppointments = false, ?string $searchByName = null): LengthAwarePaginator;
}
