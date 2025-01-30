<?php

namespace App\Services;

use App\Models\Appointment;
use App\Repositories\IAppointmentRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class AppointmentService
{
    public function __construct(protected IAppointmentRepository $repository) {}

    public function list(): LengthAwarePaginator
    {
        return $this->repository->list();
    }

    public function store(array $data): Appointment
    {
        return $this->repository->store($data);
    }
}
