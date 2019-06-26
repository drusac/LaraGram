<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = []; // laravel default protection, with this its disabled so we can update data as we said in ProfilesController.php@update

    public function profileImage(){
        $imagePath = ($this->image) ? $this->image : 'profile/xuFc3IVNHniMMrO78CNEnzBNx5g1Bd8jwcoAFKXi.png';

        return '/storage/' . $imagePath;
    }

    public function followers(){
        return $this->belongsToMany(User::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

