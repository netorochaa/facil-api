<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\IUserRepository;

class UserRepositoryEloquent implements IUserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }
}
