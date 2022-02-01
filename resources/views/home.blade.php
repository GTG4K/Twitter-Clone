@extends('layouts.layout')

@section('content')

<div class="home_container">
    <div class="frontpage">

        <form method='POST' action="/new_post" enctype="multipart/form-data">
            @csrf
            <div class="new_post">
                <div class="post_input">
                    <img src="{{ Auth::user()->profile_picture }}" alt="">
                    <input type="text" placeholder="What's on your mind?" name='description'>
                </div>
                <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                <input type="file" name="image">
            </div>
        </form>

        @foreach ($posts as $post)
        
        <div class="post">
            <div class="post_top">
                <div class="author">
                        <a href="/profile/{{$post->user_id}}"><img src="{{$users[$post['user_id']-1]['profile_picture']}}" alt=""></a>
                        <a href="/profile/{{$post->user_id}}"><h3>{{$post['author']}}</h3></a>
                </div>
                @if ($post['user_id'] ==  Auth::user()->id)
                <div class="more_options">
                    <button class="dropbtn"><i class="fas fa-ellipsis-h"></i></button>
                    <div class="dropdown_content">
                        <form method="POST" action="/delete_post">
                            @csrf
                            <button>Delete</button>
                            <input type="hidden" value="{{$post['id']}}" name="post_id">
                        </form>
                    </div>
                </div>
                @endif
            </div>
            <a href="/post/{{$post['id']}}">
                <img src="{{$post['image']}}" alt="">
            </a>
            <p>{{$post['description']}}</p>
        </div>
        
        @endforeach
    </div>

    <div class="between_sidebar"></div>

    <div class=sidebar>
        <div class="popular_posts">
            <h1>Most popular</h1>
            @foreach ($popular_posts as $pp)
                <div class="popular_post">
                    <div class="popular_post_details">
                        <h4> posted by {{$pp['author']}}</h4>
                        <p>{{$pp['description']}}</p>
                        <p>{{$pp['views']}} likes</p>
                    </div>
                    <img src="{{$pp['image']}}" alt="">
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
