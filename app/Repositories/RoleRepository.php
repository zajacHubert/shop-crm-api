<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\CategoryResource;
use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleRepository implements RoleRepositoryInterface
{
    private Role $roleModel;

    public function __construct(Role $roleModel)
    {
        $this->roleModel = $roleModel;
    }

    public function index(): ResourceCollection
    {
        $roles = $this->roleModel::all();
        return CategoryResource::collection($roles);
    }
}
