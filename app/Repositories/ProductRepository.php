<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductRepository implements ProductRepositoryInterface
{
    private Product $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function index(Request $request): ResourceCollection
    {
        $query = $this->productModel::with('category');

        if ($request->has('category')) {
            $categoryName = $request->input('category');
            $query->whereHas('category', function ($query) use ($categoryName) {
                $query->where('name', $categoryName);
            });
        }

        if ($request->has('sortParam')) {
            $sortParam = $request->input('sortParam');
            $direction = $request->input('direction', 'asc');

            $query->orderBy($sortParam, $direction);
        }

        $products = $query->paginate(10);
        return ProductResource::collection($products);
    }

    public function show(string $id): ProductResource
    {
        return new ProductResource($this->productModel::with('category')->find($id));
    }
}
