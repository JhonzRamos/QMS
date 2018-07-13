<?php

namespace App\Providers;
use App\Role;
use App\User;
//MODEL//
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        $user = \Auth::user();


        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('risktreatmentoptions_access', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risktreatmentoptions_create', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risktreatmentoptions_view', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risktreatmentoptions_edit', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risktreatmentoptions_delete', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risklikelihood_access', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risklikelihood_create', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risklikelihood_view', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risklikelihood_edit', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risklikelihood_delete', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskconsequence_access', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskconsequence_create', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskconsequence_view', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskconsequence_edit', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskconsequence_delete', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskexposure_access', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskexposure_create', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskexposure_view', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskexposure_edit', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskexposure_delete', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('responsibility_access', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('responsibility_create', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('responsibility_view', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('responsibility_edit', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('responsibility_delete', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskcategory_access', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskcategory_create', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskcategory_view', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskcategory_edit', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('riskcategory_delete', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risks_access', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risks_create', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risks_view', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risks_edit', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('risks_delete', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('strategies_access', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('strategies_create', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('strategies_view', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('strategies_edit', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('strategies_delete', function ($user) { 
             return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('management_access', function ($user) {
             return in_array($user->role_id, [1,2]);
        });
        Gate::define('riskmatrix_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        //APPEND//

    }
}
