<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->getUsersWeather();

        return response()->json(UserResource::collection($users));
    }
}
