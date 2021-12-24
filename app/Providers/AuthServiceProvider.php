<?php

namespace App\Providers;

use App\Enums\Publishing;
use App\Models\Friends;
use App\Models\Memory;
use App\Models\User;
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

        Gate::define('show-memory', function (User $user, Memory $memory) {


           return $memory->publishing === Publishing::P_PUBLIC ||     //public -> true
                  $user->id === $memory->user_id ||                   //owner -> true
                  ($memory->publishing === Publishing::P_FRIENDS      //protected -> friends only
                         && Friends::isFriend($user->id,$memory->user_id));

           // return $user->id === $memory->user_id;
        });

        Gate::define('memory-owner', function (User $user, Memory $memory) {
            return $user->id === $memory->user_id;
        });
    }
}
