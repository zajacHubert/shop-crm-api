<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Resources\Json\ResourceCollection;

interface CategoryRepositoryInterface
{
    public function index(): ResourceCollection;
}
