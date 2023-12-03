<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface UserRepositoryInterface
{
    public function index(Request $request): ResourceCollection;
    public function show(string $id): ?UserResource;
}
