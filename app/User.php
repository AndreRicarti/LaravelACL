<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Permission;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        // Retorna os papeis que esse usuário tem no sistema
        return $this->belongsToMany(\App\Role::class);
    }

    public function hasPermission(Permission $permission)
    {
        //Recupera todas funções, permissão vinculada 
        //view_post => Manager, Editor
        return $this->hasAnyRoles($permission->roles);
    }

    public function hasAnyRoles($roles)
    {
        //O usuário Carlos ele tem as permissões Manager ou Editor?
        if (is_array($roles) || is_object($roles)) {
            foreach ($roles as $role) {
                var_dump($role->name);
                //Verifica se o usuário contem as permissões
                //return $this->roles->contains('name', $role->name); // Retorna true
                //return $this->hasAnyRoles($role);

                //Verifica se o usuário esta vinculado ao perfil manager
                //Retorna a quantidade de vinculo
                // !! Se retorna erro retorna true e se retornar 0 retorna false
                return !! $roles->intersect($this->roles)->count();
            }
        }

        //contains retorna true ou false
        return $this->roles->contains('name', $roles); // Retorna falso
    }
}
