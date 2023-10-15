<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryRepository implements CategoryRepositoryInterface
{
    private Category $categoryModel;

    public function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    public function index(): ResourceCollection
    {
        $categories = $this->categoryModel::all();
        return CategoryResource::collection($categories);
    }
}
