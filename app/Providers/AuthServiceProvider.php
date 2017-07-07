<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Post;
use App\User;
use App\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //\App\Post::class => \App\Policies\PostPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*
        Gate::define('update-post', function(User $user, Post $post) {
            return $user->id == $post->user_id;
        });
        */

        //Retorna todas permissões e trás um objeto de todas funções especificas dessa permission
        //view_post ==> Manager, Editor
        //delete_post ==> Manager
        //edit_post ==> Manager
        $permissions = Permission::with('roles')->get();
        foreach($permissions as $permission)
        {
            //($permission->name == view_post)
            Gate::define($permission->name, function(User $user) use ($permission){
                //Manda o objeto $permission para o método hasPermission
                return $user->hasPermission($permission);
            });
        }

        //Before sempre verifica antes.
        Gate::before(function(User $user, $ability) {
            if ($user->hasAnyRoles('adm')) {
                return true;
            }
        });
    }
}
