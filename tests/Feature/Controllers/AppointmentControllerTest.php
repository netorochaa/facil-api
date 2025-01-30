<?php

namespace Tests\Feature\Controllers;

use App\Models\Appointment;
use App\Traits\Tests\ActingJwt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentControllerTest extends TestCase
{
    use ActingJwt;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingJwt();
    }

    public function test_it_creates_a_new_appointment()
    {
        $appointment = Appointment::factory()->make();

        $response = $this->postJson(route('appointments.store'), $appointment->toArray(), [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['id' => 1]);
    }

    public function test_it_validates_required_fields()
    {
        $appointmentData = [];

        $response = $this->postJson(route('appointments.store'), $appointmentData, [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertStatus(500);
        $response->assertJson(['message' => 'O campo médico é obrigatório. (and 2 more errors)']);
    }

    public function test_it_returns_a_list_of_appointments()
    {
        Appointment::factory()->count(5)->create();

        $response = $this->getJson(route('appointments.index'), [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertSuccessful();
        $response->assertJsonCount(5, 'data');
    }
}
