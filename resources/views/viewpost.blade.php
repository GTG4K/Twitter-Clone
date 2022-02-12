@extends('layouts.layout')

@section('content')

<link href="{{ asset('/css/view_post.css') }}" rel="stylesheet"> 

<div class="view_post_container">

    <div class="view_post_main">

        {{-- Post --}}
        <div class="post">

            {{-- profile picture/ author name/ upload date/ additional info button --}}
            <div class="post_header">
                <a href="/profile/{{$post_author->id}}">
                    <div class="post_header_details">
                        <img src="{{$post_author->profile_picture}}" alt="">
                        <div class="name_date_desc">
                            <div class="name_date">
                                <h3>{{$post_author->name}}</h3>
                                <div class='separator'>
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="label">{{$post_time_stamp[0][0]}} {{$post_time_stamp[0][1]}}, {{$post_time_stamp[0][2]}}</div>
                            </div>
                            <p>{{$post->description}}</p>
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
                                <input type="hidden" value="{{$post->id}}" name="post_id">
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="post_body">
                @if($post->image != NULL)
                <img src="{{$post->image}}" alt="">
                @endif
            </div>

            <div class="post_spacing"></div>

            <div class="post_stats">
                @if($post_reposts[0][0]->reposted == 0)
                <div class="post_stats_item repost">
                    <form method='POST' action="/repost_post">
                        @csrf
                        <button><i class="fas fa-retweet"></i></button>
                        <span>{{$post_reposts_count[0]}}</span>
                        <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                        <input type="hidden" value="{{$post_reposts[0][0]->post_id}}" name="post_id">
                    </form>
                </div>
                @else
                <div class="post_stats_item active repost">
                    <form method='POST' action="/repost_post">
                        @csrf
                        <button><i class="fas fa-retweet"></i></button>
                        <span>{{$post_reposts_count[0]}}</span>
                        <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                        <input type="hidden" value="{{$post_reposts[0][0]->post_id}}" name="post_id">
                    </form>
                </div>
                @endif
                
                @if($post_likes[0][0]->liked == 0)
                <div class="post_stats_item like">
                    <form method='POST' action="/like_post">
                        @csrf
                        <button><i class="far fa-heart"></i></button>
                        <span>{{$post_likes_count[0]}}</span>
                        <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                        <input type="hidden" value="{{$post_likes[0][0]->post_id}}" name="post_id">
                    </form>
                </div>
                @else
                <div class="post_stats_item active like">
                    <form method='POST' action="/like_post">
                        @csrf
                        <button><i class="far fa-heart"></i></button>
                        <span>{{$post_likes_count[0]}}</span>
                        <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                        <input type="hidden" value="{{$post_likes[0][0]->post_id}}" name="post_id">
                    </form>
                </div>
                @endif

                @if($post_favorites[0][0]->favorited == 0)
                <div class="post_stats_item favorite">
                    <form method='POST' action="/favorite_post">
                        @csrf
                        <button><i class="far fa-bookmark"></i></button>
                        <span>{{$post_favorites_count[0]}}</span>
                        <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                        <input type="hidden" value="{{$post_favorites[0][0]->post_id}}" name="post_id">
                    </form>
                </div>
                @else
                <div class="post_stats_item active favorite">
                    <form method='POST' action="/favorite_post">
                        @csrf
                        <button><i class="far fa-bookmark"></i></button>
                        <span>{{$post_favorites_count[0]}}</span>
                        <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                        <input type="hidden" value="{{$post_favorites[0][0]->post_id}}" name="post_id">
                    </form>
                </div>
                @endif

                <div class="post_stats_item">
                    <form action="">
                        <button><i class="far fa-bookmark"></i></button>
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
                    <input type="hidden" value="{{$post->id}}" name="post_id">
                </div>
            </form>
        </div>

        {{-- Comments --}}
        @for($i=0; $i < $comments->count(); $i++)
        <div class="post">

            {{-- profile picture/ author name/ upload date/ additional info button --}}
            <div class="post_header">
                <a href="/profile/{{$comment_authors[$i]->id}}">
                    <div class="post_header_details">
                        <img src="{{$comment_authors[$i]->profile_picture}}" alt="">
                        <div class="name_date_desc">
                            <div class="name_date">
                                <h3>{{$comment_authors[$i]->name}}</h3>
                                <div class='separator'>
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="label">{{$comment_time_stamps[$i][0]}} {{$comment_time_stamps[$i][1]}}, {{$comment_time_stamps[$i][2]}}</div>
                            </div>
                            <p>{{$comments[$i]->comment}}</p>
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
                                <input type="hidden" value="{{$post->id}}" name="post_id">
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            @if($comments[$i]->image != NULL)
            <div class="post_body">
                <img src="{{$comments[$i]->image}}" alt="">
            </div>
            @endif
            
        </div>
        @endfor
    </div>

    <div class="view_post_side">
        
    </div>

</div>

@endsection