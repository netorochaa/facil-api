<?php

namespace App\Repositories;

use App\Models\Appointment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IAppointmentRepository
{
    public function list(): LengthAwarePaginator;

    public function store(array $data): Appointment;
}
