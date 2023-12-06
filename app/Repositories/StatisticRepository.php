<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\StatisticRepositoryInterface;

class StatisticRepository implements StatisticRepositoryInterface
{
    private Order $orderModel;

    public function __construct(Order $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function getMonthlySales(): array
    {
        $startDate = now()->subMonths(12)->startOfMonth();
        $results = [];

        for ($i = 0; $i < 12; $i++) {
            $currentStartDate = $startDate->copy()->addMonths($i);
            $currentEndDate = $currentStartDate->copy()->endOfMonth();

            $sum = $this->orderModel::whereBetween('created_at', [$currentStartDate, $currentEndDate])
                ->sum('value');

            $results[] = [
                'month' => $currentStartDate->format('F Y'),
                'value' => $sum,
            ];
        }

        return $results;
    }
}
