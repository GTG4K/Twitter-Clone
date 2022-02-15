@extends('layouts.layout')

@section('content')

<?php
    // include 'App\Http\Controllers\DBHController.php'
?>

<link href="{{ asset('/css/home.css') }}" rel="stylesheet"> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="home_container">
    {{-- Displays Middle part of home page --}}
    <div class="home_main">
        <div class="home_element">
        <div class='home_element_title'>
            <i class="fa fa-users"></i>
            <h2> Users </h2>
        </div>
        @for($i=0; $i<$users->count(); $i++)
        <a href="/profile/{{$users[$i]->id}}">
            <div class="user">
                <img src="{{$users[$i]->profile_picture}}" alt="">
                <div class="user_details">
                    <h2>{{$users[$i]->name}}</h2>
                    <p>Followers: {{$users_follow_details[$i][1]}}</p>
                </div>
                @if(Auth::user()->id != $users[$i]->id)
                <form method="POST" action="/profile/follow">
                    @csrf
                    @if($users_follow_details[$i][1]==0)
                    <button>Follow</button>
                    @elseif($users_follow_details[$i][1]==1)
                    <button class=unfollow>Following</button>
                    @endif
                    <input type="hidden" value="{{Auth::user()->id}}" name="follower_id">
                    <input type="hidden" value="{{$users[$i]->id}}" name="following_id">
                </form>
                @endif
            </div>
        </a>
        @endfor
        </div>
    </div>

    <div class="home_side">

        <div class="side_element">
            <div class="search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search" id="search">
            </div>
            <div id="search_result">
            
            </div>
        </div>

        {{--users side element--}}

        <footer>
            <p>საიტი თუ უბერავს და Cashe-ის წაშლა არ შველის შეგიქლიათ თარხნას შეხვდეთ ბიბლიოთეკაში</p>
        </footer>
    </div>
</div>

@endsection
