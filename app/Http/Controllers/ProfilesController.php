<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; // for profile image
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    public function index(User $user){
        // dd($user);
        // $user = User::findOrFail($user); // in url enter id that doesnt exist, app returns 404 not found, proper response..not ugly lrvl error page
        // refactor this with index(\App\User $user), laravel finds user for us, no need to findOrFail($user)

        // return view('profiles.index', [ // refactor also to line down there
        //     'user' => $user,
        // ]);
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postCount = Cache::remember(
            'count.posts.' .$user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->posts->count();
        });

        $followersCount = Cache::remember(
            'count.followers.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->profile->followers->count();
        });

        $followingCount = Cache::remember(
            'count.following.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->following->count();
        });

        // dd($follows);

        return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
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


        if (request('image')){
            $imagePath = (request('image')->store('profile', 'public'));

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $imageArray = ['image' => $imagePath]; // updating / not updating profile picture
        }

        // dd(array_merge(
        //     $data,
        //     ['image' => $imagePath]
        // ));

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? [] // if not set in request, imagearray will be empty, when we edit profile we can edit without uploading new picture
        )); // extra layer of protection, only grab the authenticated user, doesnt matter what they giving throught the query (url)

        return redirect("/profile/{$user->id}");
    }
}
