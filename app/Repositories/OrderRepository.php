<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderRepository implements OrderRepositoryInterface
{
    private Order $orderModel;

    public function __construct(Order $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function index(Request $request): ResourceCollection
    {
        $query = $this->orderModel::with(['user', 'orderItems.product']);

        if ($request->has('sortParam')) {
            $sortParam = $request->input('sortParam');
            $direction = $request->input('sortDirection', 'asc');

            switch ($sortParam) {
                case 'name':
                    $query->with(['user' => function ($query) use ($direction) {
                        $query->orderBy('last_name', $direction);
                    }]);
                    break;

                case 'email':
                    $query->with(['user' => function ($query) use ($direction) {
                        $query->orderBy('email', $direction);
                    }]);
                    break;

                case 'date':
                    $query->orderBy('created_at', $direction);
                    break;

                default:
                    $query->orderBy($sortParam, $direction);
                    break;
            }
        }

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('value', 'like', "%$searchTerm%");
                $query->orWhereHas('user', function ($query) use ($searchTerm) {
                    $query->whereRaw('LOWER(first_name) like ?', ["%" . strtolower($searchTerm) . "%"])
                        ->orWhereRaw('LOWER(last_name) like ?', ["%" . strtolower($searchTerm) . "%"])
                        ->orWhereRaw('LOWER(email) like ?', ["%" . strtolower($searchTerm) . "%"]);
                });
                $query->orWhereRaw('LOWER(created_at) like ?', ["%" . strtolower($searchTerm) . "%"]);
            });
        }

        $orders = $query->paginate(10);
        return OrderResource::collection($orders);
    }

    public function show(string $id): OrderResource
    {
        return new OrderResource($this->orderModel::with(['user.roles', 'orderItems.product'])->find($id));
    }
}
