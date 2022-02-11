@extends('layouts.layout')

@section('content')

<?php
    // include 'App\Http\Controllers\DBHController.php'
?>

<link href="{{ asset('/css/home.css') }}" rel="stylesheet"> 


<div class="home_container">
    {{-- Displays Middle part of home page --}}
    <div class="home_main">
        
        {{-- New Post --}}
        <form  autocomplete="off" method='POST' action="/new_post" enctype="multipart/form-data">
        @csrf
            <div class="new_post">
                <div class="new_post_left">
                    <img src="{{Auth::user()->profile_picture}}" alt="">

                    @if ($errors->any()) 
                    <input type="text" placeholder="{{$errors->first()}}"  name='description'>
                    @else
                    <input type="text" placeholder="nsfw პოსტის დადება ისჯება თარხნასთან lol-ის თამაშით"  name='description'>
                    @endif
                </div>
                <div class="new_post_inputs">
                    <label for="image">
                        <i class="far fa-images"></i>
                    </label>
                    <input type="file" name="image" id="image">
                    <button type="submit">Post</button>
                </div>  
                <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
            </div>
        </form>

        {{-- Posts List --}}
        @for($i=0; $i < $posts->count(); $i++)
        <div class="post">

            {{-- profile picture/ author name/ upload date/ additional info button --}}
            <div class="post_header">
                <a href="/profile/{{$post_authors[$i]->id}}">
                    <div class="post_header_details">
                        <img src="{{$post_authors[$i]->profile_picture}}" alt="">
                        <div class="name_date_desc">
                            <div class="name_date">
                                <h3>{{$post_authors[$i]->name}}</h3>
                                <div class='separator'>
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="label">{{$timestamps[$i][0]}} {{$timestamps[$i][1]}}, {{$timestamps[$i][2]}}</div>
                            </div>
                            <p>{{$posts[$i]->description}}</p>
                        </div>    
                    </div>
                </a>
                @if(Auth::user()->id == $post_authors[$i]->id)
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

            <div class="post_spacing"></div>

            <div class="post_stats">
                <div class="post_stats_item">
                    <form action="/post/{{$posts[$i]->id}}">
                        <button><i class="far fa-comment-alt"></i></button>
                        <span>{{$post_comments_count[$i]}}</span>
                    </form>
                </div>

                @if($post_reposts[$i][0]->reposted==0)
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

            <div class="post_spacing"></div>

            <form autocomplete="off" method='POST' action="/new_comment" enctype="multipart/form-data">
                @csrf
                <div class="post_add_comment">
                    <div class="post_add_comment_left">
                        <a href="/profile/{{Auth::user()->id}}">
                        <img src="{{Auth::user()->profile_picture}}" alt="">
                        </a>

                        @if ($errors->any()) 
                        <input type="text" placeholder="{{$errors->first()}}"  name='comment'>
                        @else
                        <input type="text" placeholder="ბილწი კომენტარის დამწერს ვნახავ ბიბლიოთეკასთან"  name='comment'>
                        @endif
                    </div>

                    <div class="post_add_comment_inputs">
                        <label for="comment_image">
                            <i class="far fa-images"></i>
                        </label>
                        <input type="file" name="comment_image" id="comment_image">
                        <button type="submit">Comment</button>
                    </div>  
                    <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                    <input type="hidden" value="{{$posts[$i]->id}}" name="post_id">
                </div>
            </form>
        </div>
        @endfor
    </div>

    <div class="home_side">

        {{--users side element--}}
        <div class="side_element">
            <div class='side_element_title'>
                <i class="fa fa-users"></i>
                <h2> Users </h2>
            </div>
            @foreach ($users as $user)
            <a href="/profile/{{$user->id}}">
                <div class="user">
                    <img src="{{$user->profile_picture}}" alt="">
                    <div class="user_details">
                        <h2>{{$user->name}}</h2>
                        <p>{{$user->bio}}</p>
                    </div>
                </div>
            </a>
            @endforeach
            <div class="more_button">
                <a href="#">
                    <p>See all</p>
                </a>
            </div>
        </div>

        <footer>
            <p>საიტი თუ უბერავს და Cashe-ის წაშლა არ შველის შეგიქლიათ თარხნას შეხვდეთ ბიბლიოთეკაში</p>
        </footer>
    </div>
</div>

<script type="text/javascript" src="{{url('js/home.js')}}"></script>
@endsection
