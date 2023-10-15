<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class ProductService implements ProductServiceInterface
{
    private Product $productModel;
    private ProductRepositoryInterface $productRepository;

    public function __construct(
        Product $productModel,
        ProductRepositoryInterface $productRepository
    ) {
        $this->productModel = $productModel;
        $this->productRepository = $productRepository;
    }

    public function store(Request $request): Response
    {
        $id = Str::uuid()->toString();
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $newFileName = $id . '.' . $extension;
        $path = $file->storeAs('images', $newFileName, 'public');

        $product = $this->productModel::create([
            'id' => $id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $path,
            'price' => $request->input('price'),
            'category_id' => $request->input('category_id'),
        ]);

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }

    public function update(string $id, Request $request): Response
    {
        $product = $this->productRepository->show($id);
        $product->update($request->only('title', 'description', 'image', 'price', 'category_id'));

        return response(new ProductResource($product), Response::HTTP_ACCEPTED);
    }

    public function destroy(string $id): Response
    {
        $success = $this->productModel::destroy($id);

        return response([
            'isSuccess' => boolval($success),
        ]);
    }
}
