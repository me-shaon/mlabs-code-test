<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController
{
    public function index(): JsonResponse
    {
        return response()->json(UserResource::collection(User::with('weather')->get()));
    }
}
