@extends('layouts.layout')

@section('content')

<link href="{{ asset('/css/profile.css') }}" rel="stylesheet"> 

<div>
<div class="profile_container">
    <img class="profile_backdrop" src="{{$user['profile_background']}}" alt="">
    <img class="profile_picture" src="{{$user['profile_picture']}}" alt="">

    <div class="profile_frame">
        <div class="profile_flex top_row">
            <h1>{{$user['name']}}</h1>

            @if (Auth::user()->id == $user['id'])
                <a class='edit' href="/profile/{{$user['id']}}/edit">edit</a>
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
            @if ($user->website)
            <a class='linkout website' href="{{$user->website}}"><i class="fas fa-link"></i></a>
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

    <div class="content_display_comment">
        @for($i=0; $i < $comments->count(); $i++)
        <div class="content_comment">
            <div class="comment_flex">
                <a href="/profile/{{$users[$i]->id}}">
                    <div class="commented_on">
                        <img class="profile_picture" src="{{$users[$i]->profile_picture}}" alt="">
                        <p>{{$users[$i]->name}}</p>
                    </div>
                </a>
                <i class="fas fa-arrow-right arrow"></i>
                <a class='comment_details_a' href="/post/{{$comments[$i]['post_id']}}">
                <div class='comment_details'>
                    <img class="profile_picture" src="{{$user->profile_picture}}" alt="">
                    <div class='comment_details_info'>
                        <div class="comment_details_info_spacer"></div>
                        <h3>{{$comments[$i]['comment']}}</p> 
                        <p>commented on {{$comments[$i]->created_at}}</p>
                    </div>
                </div>
                </a>
            </div>
        </div>
        @endfor
    </div>
    
</div>
</div>

@endsection