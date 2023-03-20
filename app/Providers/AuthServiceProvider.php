<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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
        $this->registerPeoplePolicies();
 
        //
    }
   
 public function registerPeoplePolicies(){
        Gate::define('InsertDataPeople',function ($user){
            return $user->hasAccess(['InsertDataPeople']);
        });
        Gate::define('InsertDataPeople',function ($user){
            return $user->hasRole('head');
        });
    }

}
