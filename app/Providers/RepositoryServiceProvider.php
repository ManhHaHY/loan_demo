<?php

namespace App\Providers;

use App\Interfaces\LoanInterface;
use App\Interfaces\PaymentInterface;
use App\Interfaces\UserInterface;
use App\Repositories\LoanRepo;
use App\Repositories\PaymentRepo;
use App\Repositories\UserRepo;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(LoanInterface::class, LoanRepo::class);
        $this->app->bind(UserInterface::class, UserRepo::class);
        $this->app->bind(PaymentInterface::class, PaymentRepo::class);
    }
}
