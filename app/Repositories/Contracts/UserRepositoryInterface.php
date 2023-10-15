<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface UserRepositoryInterface
{
    public function index(): ResourceCollection;
    public function show(string $id): ?UserResource;
}
