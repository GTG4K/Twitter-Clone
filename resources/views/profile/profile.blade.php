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
        <a href="">Posts</a>
        <a href="">Comments</a>
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