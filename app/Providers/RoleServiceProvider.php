<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\RoleRepository;
use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
