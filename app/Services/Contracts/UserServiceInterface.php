<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

interface UserServiceInterface
{
    public function store(UserStoreRequest $request): Response;
    public function update(string $id, UserUpdateRequest $request): Response;
    public function destroy(string $id): Response;
    public function register(UserRegisterRequest $request): Response;
    public function login(UserLoginRequest $request): Response;
    public function user(Request $request): ?UserResource;
    public function logout(): Response;
}
