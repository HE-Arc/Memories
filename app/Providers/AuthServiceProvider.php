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

        //check if a user can see a memory
        Gate::define('show-memory', function (User $user, Memory $memory) {

          //rule :
           return $memory->publishing === Publishing::P_PUBLIC ||     //public -> true
                  $user->id === $memory->user_id ||                   //owner -> true
                  ($memory->publishing === Publishing::P_FRIENDS      //protected -> friends only
                         && Friends::isFriend($user->id,$memory->user_id));
        });

        //check if a user is the owner of a memory
        Gate::define('memory-owner', function (User $user, Memory $memory) {
            return $user->id === $memory->user_id;
        });

        //check if a user is a part of the friendship
        Gate::define('friendship-owner', function (User $user, Friends  $friends) {
            return ($user->id === $friends->user_id) || ($user->id === $friends->friend_id) ;
        });
    }
}
