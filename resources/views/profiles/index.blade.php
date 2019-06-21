@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="https://instagram.fzag3-1.fna.fbcdn.net/vp/b771604bcdf438d28b60c601fb73fcff/5D8CE438/t51.2885-19/s150x150/22709172_932712323559405_7810049005848625152_n.jpg?_nc_ht=instagram.fzag3-1.fna.fbcdn.net" class="rounded-circle">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1>{{ $user->username }}</h1>
                <a href="#">Add New Post</a>
            </div>
            <div class="d-flex">
                <div class="pr-5"><strong>154</strong> posts</div>
                <div class="pr-5"><strong>23k</strong> followers</div>
                <div class="pr-5"><strong>212</strong> following</div>
            </div>
            <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="#">{{ $user->profile->url }}</a></div>
        </div>
    </div>

    <div class="row pt-5">
        <div class="col-4">
            <img src="https://instagram.fzag3-1.fna.fbcdn.net/vp/01f98170a299f1607e80e5cb0d80337d/5DC6435A/t51.2885-15/sh0.08/e35/c1.0.748.748a/s640x640/61385051_380056959282372_1401946528830754601_n.jpg?_nc_ht=instagram.fzag3-1.fna.fbcdn.net" class="w-100">
        </div>
        <div class="col-4">
            <img src="https://instagram.fzag3-1.fna.fbcdn.net/vp/a483efa822a442f5eaf61f8216a8d089/5D886770/t51.2885-15/sh0.08/e35/c0.104.918.918/s640x640/60878664_2338951489496025_7878833555420019308_n.jpg?_nc_ht=instagram.fzag3-1.fna.fbcdn.net" class="w-100">
        </div>
        <div class="col-4">
            <img src="https://instagram.fzag3-1.fna.fbcdn.net/vp/435cfbf924189cdc3acdb2cf8ed33a2d/5DC4E4E3/t51.2885-15/sh0.08/e35/c6.0.738.738a/s640x640/59671261_300909900824870_753589034962477580_n.jpg?_nc_ht=instagram.fzag3-1.fna.fbcdn.net" class="w-100">
        </div>
    </div>
</div>
@endsection
