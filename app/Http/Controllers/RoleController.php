<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleController extends Controller
{
    private RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index(): ResourceCollection
    {
        return $this->roleRepository->index();
    }
}
