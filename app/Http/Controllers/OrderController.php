<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderController extends Controller
{
    private OrderRepositoryInterface $orderRepository;
    private OrderServiceInterface $orderService;

    public function __construct(OrderRepositoryInterface $orderRepository, OrderServiceInterface $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }

    public function index(Request $request): ResourceCollection
    {
        return $this->orderRepository->index($request);
    }

    public function show(string $id): OrderResource
    {
        return $this->orderRepository->show($id);
    }

    public function store(OrderStoreRequest $request): Response
    {
        return $this->orderService->store($request);
    }

    public function update(string $id, OrderUpdateRequest $request): Response
    {
        return $this->orderService->update($id, $request);
    }

    public function destroy(string $id): Response
    {
        return $this->orderService->destroy($id);
    }

    public function processPayment(Request $request): Response
    {
        return $this->orderService->processPayment($request);
    }
}
