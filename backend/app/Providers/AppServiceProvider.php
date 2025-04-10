<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\JobListingRepositoryInterface;
use App\Repositories\JobListingRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(JobListingRepositoryInterface::class, JobListingRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
