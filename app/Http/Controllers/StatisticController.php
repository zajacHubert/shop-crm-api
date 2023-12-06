<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\Contracts\StatisticRepositoryInterface;

class StatisticController extends Controller
{
    private StatisticRepositoryInterface $statisticRepository;

    public function __construct(StatisticRepositoryInterface $statisticRepository)
    {
        $this->statisticRepository = $statisticRepository;
    }
    public function getMonthlySales(): array
    {
        return $this->statisticRepository->getMonthlySales();
    }
}
