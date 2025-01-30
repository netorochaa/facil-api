<?php

namespace App\Services;

use App\Models\Patient;
use App\Repositories\IPatientRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientService
{
    public function __construct(protected IPatientRepository $repository) {}

    public function list(array $params): LengthAwarePaginator
    {
        $searchByName = data_get($params, 'nome');

        return $this->repository->list($searchByName);
    }

    public function store(array $data): Patient
    {
        return $this->repository->store($data);
    }

    public function update(array $data, int $id): Patient
    {
        $this->repository->update($data, $id);

        return $this->repository->find($id);
    }

    public function listByDoctor(array $params, int $doctorId): LengthAwarePaginator
    {
        $onlyPendingAppointments = false;

        if (isset($params['apenas-agendadas'])) {
            $onlyPendingAppointments = filter_var($params['apenas-agendadas'], FILTER_VALIDATE_BOOLEAN);
        }

        $searchByName = data_get($params, 'nome');

        return $this->repository->listByDoctor($doctorId, $onlyPendingAppointments, $searchByName);
    }
}
