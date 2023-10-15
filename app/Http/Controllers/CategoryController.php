<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): ResourceCollection
    {
        return $this->categoryRepository->index();
    }
}
