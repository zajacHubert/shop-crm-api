<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Symfony\Component\HttpFoundation\Response;

interface ProductServiceInterface
{
    public function store(ProductStoreRequest $request): Response;
    public function update(string $id, ProductUpdateRequest $request): Response;
    public function destroy(string $id): Response;
}
