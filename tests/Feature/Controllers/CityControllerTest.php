<?php

namespace Tests\Feature\Controllers;

use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_list_of_cities()
    {
        City::factory()->count(5)->create();

        $response = $this->getJson(route('cities.index'));

        $response->assertSuccessful();
        $response->assertJsonCount(5, 'data');
    }

    public function test_it_returns_a_list_of_cities_with_search()
    {
        City::factory()->count(5)->create();

        $city = City::factory()->create(['name' => 'Test City']);

        $response = $this->getJson(route('cities.index', ['nome' => 'Test City']));

        $response->assertSuccessful();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $city->id, 'name' => $city->name]);
    }
}
