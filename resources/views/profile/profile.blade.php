@extends('layouts.layout')

@section('content')

<div class="profile_container">
    <img class="profile_backdrop"src="{{$user['profile_background']}}" alt="">
    <img class="profile_picture" src="{{$user['profile_picture']}}" alt="">

    <div class="profile_frame">
        <div class="profile_flex top_row">
            <h1>{{$user['name']}}</h1>

            @if (Auth::user()->id == $user['id'])
                <a class='edit' href="{{$user['id']}}/edit">edit</a>
            @else
                <button>Message</button>
                <button>Follow</button>
            @endif
            @if ($user->discord)
                <a class='linkout discord' href=""><i class="fab fa-discord"></i></a>
            @endif
            @if ($user->instagram)
                <a class='linkout instagram' href=""><i class="fab fa-instagram"></i></a>
            @endif
            @if ($user->twitter)
                <a class='linkout twitter' href=""><i class="fab fa-twitter"></i></a>
            @endif
        </div>

        <div class="profile_flex mid_row">
            <h3>{{$posts->count()}} posts</h3>
            <h3>0 followers</h3>
            <h3>0 following</h3>
        </div>

        <p class="profile_flex bio">
            {{$user->bio}}
        </p>
    </div>
</div>

<div class="content_box">
    <div class="content_type">
        <a href="/profile/{{$user->id}}">Posts</a>
        <a href="/profile/{{$user->id}}/comments">Comments</a>
        <a href="">Saved</a>
        <a href="">Liked</a>
    </div>

    <div class="content_display">
        @foreach ($posts as $post)
        <div class="content_item">
            <a href="/post/{{$post['id']}}">
                <img src="{{$post['image']}}" alt="">
            </a>
        </div>
        @endforeach
    </div>
    
</div>

@endsection