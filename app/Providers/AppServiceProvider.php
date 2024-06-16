<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\LoanRepositoryInterface;
use App\Repositories\LoanRepository;
use App\Services\LoanServiceInterface;
use App\Services\LoanService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoanRepositoryInterface::class, LoanRepository::class);
        $this->app->bind(LoanServiceInterface::class, LoanService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
