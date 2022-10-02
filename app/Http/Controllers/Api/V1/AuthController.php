<?php

namespace App\Http\Controllers\Api\V1;

use App\Dtos\LoginRequestDTO;
use App\Dtos\RegisterRequestDTO;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Http\Response;

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

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $email = $request->post('email');
        $password = $request->post('password');

        if (!$email || !$password) {
            return response()->json([
                'message' => 'Thông tin không chính xác',
            ], Response::HTTP_BAD_REQUEST);
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
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'success',
        ], Response::HTTP_OK);
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $email = $request->post('email');
        $password = $request->post('password');
        $name = $request->post('name');
        if (!$email || !$password || !$name) {
            return response()->json([
                'message' => 'Thông tin không chính xác',
            ], Response::HTTP_BAD_REQUEST);
        }

        $registerDto = new RegisterRequestDTO(
          $name,
          $email,
          $password,
        );

        try {
            $this->userService->register($registerDto);

            return response()->json([
                'message' => 'success',
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => false,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
