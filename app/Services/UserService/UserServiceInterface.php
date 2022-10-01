<?php

namespace App\Services\UserService;

use App\Dtos\LoginRequestDTO;
use App\Models\User;

interface UserServiceInterface
{
    public function validateAuthUser(LoginRequestDTO $loginRequest): ?User;

    /**
     * @param User $user
     * @return string
     */
    public function createToken(User $user): string;
}
