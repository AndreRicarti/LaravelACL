<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        //Faz muitos para um
        return $this->belongsTo(User::class);
    }
}
