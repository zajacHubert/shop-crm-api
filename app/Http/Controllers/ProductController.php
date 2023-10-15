<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;
    private ProductServiceInterface $productService;

    public function __construct(ProductRepositoryInterface $productRepository, ProductServiceInterface $productService)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    public function index(Request $request): ResourceCollection
    {
        return $this->productRepository->index($request);
    }

    public function show(string $id): ProductResource
    {
        return $this->productRepository->show($id);
    }

    public function store(Request $request): Response
    {
        return $this->productService->store($request);
    }

    public function update(string $id, Request $request): Response
    {
        return $this->productService->update($id, $request);
    }

    public function destroy(string $id): Response
    {
        return $this->productService->destroy($id);
    }
}
