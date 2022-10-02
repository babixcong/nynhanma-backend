<?php

namespace App\Services\UserService;

use App\Dtos\LoginRequestDTO;
use App\Dtos\RegisterRequestDTO;
use App\Models\User;
use App\Repositories\UserRepository\UserRepositoryInterface;
use App\Services\UserService\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validateAuthUser(LoginRequestDTO $loginRequest): ?User
    {
        $user = $this->userRepository->findFirst([
            'email' => $loginRequest->getEmail(),
        ]);

        if (!$user) {
            throw new \Exception('Không tồn tại user');
        }

        if (!Hash::check($loginRequest->getPassword(), $user->password)) {
            throw new \Exception('Mật khẩu không chính xác');
        }

        $credentials = [
            'email' => $loginRequest->getEmail(),
            'password' => $loginRequest->getPassword(),
        ];
        if (!Auth::attempt($credentials)) {
            throw new \Exception('Đăng nhập thất bại', Response::HTTP_UNAUTHORIZED);
        }

        return $user;
    }

    public function createToken(User $user): string
    {
        return $user->createToken('authToken')->plainTextToken;
    }

    public function register(RegisterRequestDTO $registerRequestDTO): void
    {
        $this->userRepository->create([
            'name' => $registerRequestDTO->getName(),
            'email' => $registerRequestDTO->getEmail(),
            'password' => bcrypt($registerRequestDTO->getPassword()),
        ]);
    }
}
