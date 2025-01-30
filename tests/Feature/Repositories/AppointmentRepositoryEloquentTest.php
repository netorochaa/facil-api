<?php

namespace Tests\Feature\Repositories;

use App\Models\Appointment;
use App\Repositories\Eloquent\AppointmentRepositoryEloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentRepositoryEloquentTest extends TestCase
{
    use RefreshDatabase;

    private AppointmentRepositoryEloquent $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new AppointmentRepositoryEloquent;
    }

    public function test_it_stores_a_new_appointment()
    {
        $appointmentData = Appointment::factory()->make();

        $appointment = $this->repository->store($appointmentData->toArray());

        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertEquals($appointmentData->doctor->name, $appointment->doctor->name);
        $this->assertEquals($appointmentData->patient->name, $appointment->patient->name);
    }

    public function test_it_lists_appointments()
    {
        Appointment::factory()->count(5)->create();

        $appointments = $this->repository->list();

        $this->assertInstanceOf(LengthAwarePaginator::class, $appointments);

        $this->assertCount(5, $appointments->items());
    }
}
