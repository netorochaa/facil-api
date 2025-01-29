<?php

namespace Tests\Feature\Repositories;

use App\Models\User;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryEloquentTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_new_user()
    {
        $repository = new UserRepositoryEloquent;

        $user = $repository->create([
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('User Test', $user->name);
        $this->assertEquals('user@test.com', $user->email);
    }
}
