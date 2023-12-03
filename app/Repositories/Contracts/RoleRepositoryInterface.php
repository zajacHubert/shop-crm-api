<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Resources\Json\ResourceCollection;

interface RoleRepositoryInterface
{
    public function index(): ResourceCollection;
}
