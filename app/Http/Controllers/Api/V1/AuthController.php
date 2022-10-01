<?php

namespace App\Http\Controllers\Api\V1;

use App\Dtos\LoginRequestDTO;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\UserResource;
use App\Services\UserService\UserServiceInterface;
use Illuminate\Http\Request;
use Auth;

class AuthController extends ApiController
{
    /**
     * @var UserServiceInterface $userService
     */
    private UserServiceInterface $userService;

    /**
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $email = $request->post('email');
        $password = $request->post('password');

        if (!$email || !$password) {
            return response()->json([
                'message' => 'Thông tin không chính xác',
            ], 400);
        }
        $loginRequestDTO = new LoginRequestDTO(
            $email,
            $password
        );

        try {
            $user = $this->userService->validateAuthUser($loginRequestDTO);
            $token = $this->userService->createToken($user);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => new UserResource($user),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'success',
        ], 200);
    }
}
