<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // register the gates
        Gate::define('admin', 'App\Policies\Gates@admin');
        Gate::define('customer', 'App\Policies\Gates@customer');
        Gate::define('provider', 'App\Policies\Gates@provider');
        Gate::define('owner', 'App\Policies\Gates@owner');
        Gate::define('user', 'App\Policies\Gates@user');

        // passport registration
        Passport::routes(null, ['middleware' => 'api']);
        Passport::tokensExpireIn(now()->addSeconds(config('auth.token-expiration')));
        Passport::refreshTokensExpireIn(now()->addSeconds(config('auth.refresh-token-expiration')));
    }
}
