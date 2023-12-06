<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\StatisticRepositoryInterface;
use App\Repositories\StatisticRepository;
use Illuminate\Support\ServiceProvider;

class StatisticServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(StatisticRepositoryInterface::class, StatisticRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
