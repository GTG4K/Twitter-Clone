@extends('layouts.layout')

@section('content')

<link href="{{ asset('/css/profile.css') }}" rel="stylesheet"> 

<div class="profile_container">
    {{-- Displays Main part of Profile page --}}
    <div class="profile_main">

        <div class="profile_card">

            <img class='profile_picture_background' src="{{$user->profile_background}}" alt="">

            <div class="profile_card_details">
                <div class="profile_card_details_title">
                    <div class="profile_backdrop">
                        <img class='profile_picture' src="{{$user->profile_picture}}" alt="">
                    </div>

                    <h2>{{$user->name}}</h2>
                </div>
            </div>

            <div class="profile_stats">
                <p>Following {{$following}}</p>
                <div class='separator'>
                    <i class="fas fa-circle"></i>
                </div>
                <p>Followers {{$followers}}</p>
            </div>

            <div class="profile_bio">
                <i class="fas fa-pen"></i>
                <p>{{$user->bio}}</p>
            </div>

        </div>

        <div class="sepatator_line"></div>

        <div class="profile_additional_links_holder">

            <div class="profile_additional_links">
                @if (Auth::user()->id == $user->id)
                    <a class='edit' href="/profile/{{$user->id}}/edit"><i class="fas fa-cog"></i></a>
                @else
                    <button><i class="far fa-envelope"></i></button>

                    <form method="POST" action="/profile/follow">
                    @csrf
                        <button><i class="far fa-user"></i></button>
                        <input type="hidden" value="{{Auth::user()->id}}" name="follower_id">
                        <input type="hidden" value="{{$user->id}}" name="following_id">
                        <input type="hidden" value="{{$follow->id}}" name="follow_id">
                    </form>

                @endif
                @if($user->discord or $user->instagram or $user->twitter or $user->website)
                
                    <div class='separator'>
                        <i class="fas fa-circle"></i>
                    </div>

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

            <div class="sepatator_line"></div>

            <div class="content_type">
                <a href="/profile/{{$user->id}}">Posts</a>
                <a href="/profile/{{$user->id}}/comments">Comments</a>
                <a href="/profile/{{$user->id}}/bookmarks">bookmarks</a>
                <a href="/profile/{{$user->id}}/likes">Likes</a>
            </div>
        </div>

        <div class="content_box">
            {{-- Bookmarked Posts --}}
            @if(count($posts) == 0)
            <h2> {{$user->name}} hasn't liked anything :( </h2>
            @endif
            @for($i=0; $i < sizeof($posts); $i++)
            <div class="post">
            {{-- profile picture/ author name/ upload date/ additional info button --}}
                <div class="post_header">
                <a href="/profile/{{$post_users[$i]->id}}">
                    <div class="post_header_details">
                        <img src="{{$post_users[$i]->profile_picture}}" alt="">
                        <div class="name_date_desc">
                            <div class="name_date">
                                <h3>{{$post_users[$i]->name}}</h3>
                                <div class='separator'>
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="label">{{$time_stamps[$i][0]}} {{$time_stamps[$i][1]}}, {{$time_stamps[$i][2]}}</div>
                            </div>
                            <p>{{$posts[$i]->description}}</p>
                        </div>    
                    </div>
                </a>
                @if(Auth::user()->id == $posts[$i]->id or Auth::user()->name == 'Tarkhna')
                <div id="Dropdown" class="post_dropdown">
                    <i class="fas fa-ellipsis-h"></i>
                    <div class="post_dropdown_content">
                        <div class='post_dropdown_content_item'>
                            <form method="POST" action="/delete_post">
                                @csrf
                                <button>
                                    <i class="fas fa-trash-alt"></i>
                                    <p>Delete</p>
                                </button>
                                <input type="hidden" value="{{$posts[$i]->id}}" name="post_id">
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                </div>

                <div class="post_body">
                @if($posts[$i]->image != NULL)
                <img src="{{$posts[$i]->image}}" alt="">
                @endif
                </div>

                {{-- <div class="post_spacing"></div> --}}

                <div class="post_stats">
                    <div class="post_stats_item">
                        <form action="/post/{{$posts[$i]->id}}">
                            <button><i class="far fa-comment-alt"></i></button>
                            <span>{{$post_comments_count[$i]}}</span>
                        </form>
                    </div>

                    @if($post_reposts[$i][0]->reposted == 0)
                    <div class="post_stats_item repost">
                        <form method='POST' action="/repost_post">
                            @csrf
                            <button><i class="fas fa-retweet"></i></button>
                            <span>{{$post_reposts_count[$i]}}</span>
                            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                            <input type="hidden" value="{{$post_reposts[$i][0]->post_id}}" name="post_id">
                        </form>
                    </div>
                    @else
                    <div class="post_stats_item active repost">
                        <form method='POST' action="/repost_post">
                            @csrf
                            <button><i class="fas fa-retweet"></i></button>
                            <span>{{$post_reposts_count[$i]}}</span>
                            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                            <input type="hidden" value="{{$post_reposts[$i][0]->post_id}}" name="post_id">
                        </form>
                    </div>
                    @endif
                    
                    @if($post_likes[$i][0]->liked == 0)
                    <div class="post_stats_item like">
                        <form method='POST' action="/like_post">
                            @csrf
                            <button><i class="far fa-heart"></i></button>
                            <span>{{$post_likes_count[$i]}}</span>
                            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                            <input type="hidden" value="{{$post_likes[$i][0]->post_id}}" name="post_id">
                        </form>
                    </div>
                    @else
                    <div class="post_stats_item active like">
                        <form method='POST' action="/like_post">
                            @csrf
                            <button><i class="far fa-heart"></i></button>
                            <span>{{$post_likes_count[$i]}}</span>
                            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                            <input type="hidden" value="{{$post_likes[$i][0]->post_id}}" name="post_id">
                        </form>
                    </div>
                    @endif

                    @if($post_favorites[$i][0]->favorited == 0)
                    <div class="post_stats_item favorite">
                        <form method='POST' action="/favorite_post">
                            @csrf
                            <button><i class="far fa-bookmark"></i></button>
                            <span>{{$post_favorites_count[$i]}}</span>
                            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                            <input type="hidden" value="{{$post_favorites[$i][0]->post_id}}" name="post_id">
                        </form>
                    </div>
                    @else
                    <div class="post_stats_item active favorite">
                        <form method='POST' action="/favorite_post">
                            @csrf
                            <button><i class="far fa-bookmark"></i></button>
                            <span>{{$post_favorites_count[$i]}}</span>
                            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                            <input type="hidden" value="{{$post_favorites[$i][0]->post_id}}" name="post_id">
                        </form>
                    </div>
                    @endif

                    <div class="post_stats_item">
                        <form action="">
                            <button><i class="fas fa-coins"></i></button>
                        </form>
                    </div>
                </div> 

                {{-- <div class="post_spacing"></div> --}}

            </div>
            @endfor
        </div>
    </div>

    <div class="profile_side">

    </div>
</div>

@endsection