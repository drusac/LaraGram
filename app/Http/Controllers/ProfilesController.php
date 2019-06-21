<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index($user)
    {
        // dd($user);
        $user = User::findOrFail($user); // in url enter id that doesnt exist, app returns 404 not found, proper response

        return view('profiles.index', [
            'user' => $user,
        ]);
    }
}
