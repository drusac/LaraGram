<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = []; // if array empty, its ok, do not guard anything, mass assignment allowed

    public function user(){
        return $this->belongsTo(User::class);
    }
}
