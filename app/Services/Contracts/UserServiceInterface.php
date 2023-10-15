<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

interface UserServiceInterface
{
    public function store(Request $request): Response;
    public function update(string $id, Request $request): Response;
    public function destroy(string $id): Response;
    public function register(Request $request): Response;
    public function login(Request $request): Response;
    public function user(Request $request): ?UserResource;
    public function logout(): Response;
}
