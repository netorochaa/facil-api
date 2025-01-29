<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\IUserRepository;

class UserRespositoryEloquent implements IUserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }
}
