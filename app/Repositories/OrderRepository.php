<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderRepository implements OrderRepositoryInterface
{
    private Order $orderModel;

    public function __construct(Order $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function index(): ResourceCollection
    {
        $orders = $this->orderModel::with(['user', 'orderItems.product'])->paginate(10);
        return OrderResource::collection($orders);
    }

    public function show(string $id): OrderResource
    {
        return new OrderResource($this->orderModel::with(['user.roles', 'orderItems.product'])->find($id));
    }
}
