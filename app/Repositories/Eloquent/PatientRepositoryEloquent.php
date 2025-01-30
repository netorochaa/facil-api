<?php

namespace App\Repositories\Eloquent;

use App\Models\Patient;
use App\Repositories\IPatientRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
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

    public function listByDoctor(int $doctorId, ?bool $onlyPendingAppointments = null, ?string $searchByName = null): LengthAwarePaginator
    {
        return Patient::query()
            ->select('patients.*', 'appointments.date')
            ->join('appointments', 'appointments.patient_id', '=', 'patients.id')
            ->search($searchByName)
            ->withWhereHas('appointments', function (Builder $query) use ($doctorId, $onlyPendingAppointments) {
                $query
                    ->where('doctor_id', $doctorId)
                    ->when($onlyPendingAppointments, function (Builder $query) {
                        $query->where('date', '>', now());
                    });
            })
            ->orderBy('appointments.date')
            ->paginate(20);
    }
}
