<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

interface OrderServiceInterface
{
    public function store(OrderStoreRequest $request): Response;
    public function update(string $id, OrderUpdateRequest $request): Response;
    public function destroy(string $id): Response;
    public function processPayment(Request $request): Response;
}
