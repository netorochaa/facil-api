<?php

namespace App\Repositories\Eloquent;

use App\Models\Appointment;
use App\Repositories\IAppointmentRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class AppointmentRepositoryEloquent implements IAppointmentRepository
{
    public function store(array $data): Appointment
    {
        return Appointment::create($data);
    }

    public function list(): LengthAwarePaginator
    {
        return Appointment::query()->paginate(20);
    }
}
