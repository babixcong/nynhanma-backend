<?php

namespace App\Repositories\UserRepository;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\UserRepository\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel(): string
    {
        return User::class;
    }

}
