@extends('layouts.layout')

@section('content')

<div class="home_container">

    {{-- MAIN POST --}}
    <div>
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
            <img src="{{$post['image']}}" alt="">
            <p>{{$post['description']}}</p>
        </div>
    
        {{-- Make Comment --}}

        <form method='POST' action="/new_comment" enctype="multipart/form-data">
            @csrf
            <div class="new_post">
                <div class="post_input">
                    <img src="{{ Auth::user()->profile_picture }}" alt="">
                    <input type="text" placeholder="What's on your mind?" name='comment'>
                </div>
                <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                <input type="hidden" value="{{$post['id']}}" name="post_id">
            </div>
        </form>

        @foreach ($comments as $comment)
        <div class="post">
            <div class="post_top">
                <div class="author">
                    <a href="/profile/{{$comment->user_id}}"><img src="{{$users[$comment['user_id']-1]['profile_picture']}}" alt=""></a>
                    <div class="author_details">
                        <a href="/profile/{{$comment->user_id}}"><h3>{{$comment['author']}}</h3></a>
                        <p>Replying to <a href="/profile/{{$post->user_id}}">{{'@'.$post['author']}}</a></p>
                    </div>
                </div>
                @if ($comment['user_id'] ==  Auth::user()->id)
                <div class="more_options">
                    <button class="dropbtn"><i class="fas fa-ellipsis-h"></i></button>
                    <div class="dropdown_content">
                        <form method="POST" action="/delete_comment">
                            @csrf
                            <button>Delete</button>
                            <input type="hidden" value="{{$comment['post_id']}}" name="post_id">
                            <input type="hidden" value="{{$comment['id']}}" name="comment_id">
                        </form>
                    </div>
                </div>
                @endif
            </div>
            <p>{{$comment['comment']}}</p>
        </div>
        @endforeach


    </div>

    {{-- SIDEBAR --}}
    <div class="between_sidebar"></div>

    <div class=sidebar>
        <div class="popular_posts">
            <h1>Most popular</h1>
            @foreach ($popular_posts as $pp)
            <a href="/post/{{$pp['id']}}">
                <div class="popular_post">
                    <div class="popular_post_details">
                        <h4> posted by {{$pp['author']}}</h4>
                        <p>{{$pp['description']}}</p>
                        <p>{{$pp['views']}} likes</p>
                    </div>
                    <img src="{{$pp['image']}}" alt="">
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

@endsection