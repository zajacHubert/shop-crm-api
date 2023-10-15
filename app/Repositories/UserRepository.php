<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserRepository implements UserRepositoryInterface
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function index(): ResourceCollection
    {
        return UserResource::collection($this->userModel::with('roles')->paginate(10));
    }

    public function show(string $id): ?UserResource
    {
        return new UserResource($this->userModel::with('roles')->find($id));
    }
}
