@extends('layouts.layout')

@section('content')

<div class="profile_container">
    <img src="{{$user['profile_picture']}}" alt="">

    <div class="profile_frame">
        <div class="profile_flex top_row">
            <h1>{{$user['name']}}</h1>

            @if (Auth::user()->id == $user['id'])
                <a href="edit/{{$user['id']}}">edit</a>
            @else
                <button>Message</button>
                <button>Follow</button>
            @endif
        </div>

        <div class="profile_flex mid_row">
            <h3>{{$posts->count()}} posts</h3>
            <h3>0 followers</h3>
            <h3>0 following</h3>
        </div>

        <p class="profile_flex bio">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Ipsam odio repellat in, impedit atque facilis? 
            Reiciendis eligendi hic odit, tempora obcaecati similique, 
            quasi architecto aliquam eaque autem facere esse provident!
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

    <div class="content_display_comment">
        @for($i=0; $i < $comments->count(); $i++)
        <div class="content_comment">
            <div class="comment_flex">
                <a href="/profile/{{$users[$i]->id}}">
                    <img class="profile_picture" src="{{$users[$i]->profile_picture}}" alt="">
                </a>
                <i class="fas fa-arrow-right arrow"></i>
                <a class='comment_details_a' href="/post/{{$comments[$i]['post_id']}}">
                <div class='comment_details'>
                    <img class="profile_picture" src="{{$user->profile_picture}}" alt="">
                    <p>{{$comments[$i]['comment']}}</p>    
                </div>
                </a>
            </div>
        </div>
        @endfor
    </div>
    
</div>

@endsection