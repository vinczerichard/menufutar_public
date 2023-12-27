<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Login;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isUser', function ($user) {

            if (Auth::user()) {
                if(Auth::user()->email_verified_at != null){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        });

        Gate::define('isAdmin', function ($user) {

            if (Auth::user()->hasPermission('Admin')) {
                return true;
            }
        });
    }
}
