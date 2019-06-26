<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; // for image resizing

class PostsController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); // if this line/method exists in __constructor every single route here will require authorization
        // route is now protected with must be logged in
    }

    public function index(){
        $users = auth()->user()->following()->pluck('profiles.user_id');

        // dd($users);

        // $posts = Post::whereIn('user_id', $users)->orderBy('created_at', 'DESC')->get();
        // $posts = Post::whereIn('user_id', $users)->latest()->get(); // same as line above but shorter
        // $posts = Post::whereIn('user_id', $users)->latest()->paginate(5); // same as line above but for pagination
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5); // same as line above but for pagination and better performance // less queries
        // with('user') is about relationship in Post model

        // dd($posts);

        return view('posts.index', compact('posts'));
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

        $imagePath = (request('image')->store('uploads', 'public'));

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        // create data/new post throught a relationship between models User and Post
        // this will grab authenticated user and go into their posts and create new post
        // laravel behind the scenes is gonna add user_id for us because it knows about the relationship, it will do that automatically
        // we dont have to tell laravel my user_id is 1,2,3,4,... laravel takes care of that for us
        // only authenticated user can make new posts

        // there is better/easier way than this one ^
        // $post = new \App\Post();
        // $post->caption = $data['caption'];
        // $post->save();

        // dd(request()->all()); // print result

        return redirect('/profile/' . auth()->user()->id);
    }

    public function show(\App\Post $post){ // \App\Post gets all post details for us, not just post ID, we have everything with this line, whole post
        // dd($post);

        // return view('posts.show', [
        //     'post' => $post,
        // ]);

        // alternative - shorter return works same
        return view('posts.show', compact('post'));
    }
}
