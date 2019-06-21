<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); // if this line/method exists in __constructor every single route here will require authorization
        // route is now protected with must be logged in
    }

    public function create(){
        return view('posts.create');
    }

    public function store(){
        $data = request()->validate([
            // 'another' => '', // if you dont need validation, use syntax like this, so you can save to database (otherwise it gets ignored in create() method)
            'caption' => 'required',
            'image' => ['required', 'image'], // required and must be image -> jpeg, png, bmp, gif, or svg
        ]);

        auth()->user()->posts()->create($data); // create data/new post throught a relationship between models User and Post
        // this will grab authenticated user and go into their posts and create new post
        // laravel behind the scenes is gonna add user_id for us because it knows about the relationship, it will do that automatically
        // we dont have to tell laravel my user_id is 1,2,3,4,... laravel takes care of that for us
        // only authenticated user can make new posts

        // there is better/easier way than this one ^
        // $post = new \App\Post();
        // $post->caption = $data['caption'];
        // $post->save();

        dd(request()->all());
    }
}
