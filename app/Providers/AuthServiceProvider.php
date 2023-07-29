<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::ignoreRoutes();
        }

        Passport::tokensCan([
            'user' => 'User user type',
            'admin' => 'Admin user type',
        ]);

        Passport::setDefaultScope([
            'user',
            'admin',
        ]);

        Passport::tokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(2));
        // Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        // Passport::hashClientSecrets();
        //
    }
}
