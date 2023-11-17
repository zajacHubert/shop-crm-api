<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Support\Facades\Storage;
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

    public function store(ProductStoreRequest $request): Response
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

    public function update(string $id, ProductUpdateRequest $request): Response
    {
        $product = $this->productRepository->show($id);
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $newFileName = $id . '.' . $extension;
            $path = $file->storeAs('images', $newFileName, 'public');
            $product['image'] = $path;
        }
        $product->update([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
        ]);
        $product->save();

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
