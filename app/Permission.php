<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function roles()
    {
        //Trás todos papéis, funções vinculada a essa permission
        return $this->belongsToMany(\App\Role::class);
    }
}
