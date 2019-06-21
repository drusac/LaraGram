<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index(User $user){
        // dd($user);
        // $user = User::findOrFail($user); // in url enter id that doesnt exist, app returns 404 not found, proper response..not ugly lrvl error page
        // refactor this with index(\App\User $user), laravel finds user for us, no need to findOrFail($user)

        // return view('profiles.index', [ // refactor also to line down there
        //     'user' => $user,
        // ]);

        return view('profiles.index', compact('user'));
    }

    public function edit(User $user){ // (\App\User $user) === (User $user), because its imported with use App\User;
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    public function update(User $user){
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        // dd($data);
        // $user->profile->update($data); // bad practice, everyone, even guest can edit any user profile

        auth()->user()->profile->update($data); // extra layer of protection, only grab the authenticated user, doesnt matter what they giving throught the query (url)

        return redirect("/profile/{$user->id}");
    }
}
