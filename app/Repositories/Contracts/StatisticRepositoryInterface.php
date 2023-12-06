<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface StatisticRepositoryInterface
{
    public function getMonthlySales(): array;
}
