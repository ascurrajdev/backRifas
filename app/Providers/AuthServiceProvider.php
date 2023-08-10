<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\AdminRaffle;
use App\Policies\AdminRafflePolicy;
use App\Policies\RafflePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        AdminRaffle::class => AdminRafflePolicy::class,
        Raffle::class => RafflePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
