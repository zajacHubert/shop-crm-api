<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface OrderRepositoryInterface
{
    public function index(): ResourceCollection;
    public function show(string $id): OrderResource;
}
