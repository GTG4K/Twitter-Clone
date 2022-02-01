@extends('layouts.layout')

@section('content')

<div class='login_form'>
    <form method="POST" action="{{ route('register') }}">
        <img src="/image/aeedzlogo.svg" alt="">
        <h2>Hello There!</h2>
        @csrf
        <input  type="text" name="name" placeholder="enter your username" value="">
        @error('name')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
        @enderror 
        <input  type="email" name="email" placeholder="enter your email" value="">
        @error('email')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input  type="password" name="password" placeholder="enter your password" value="">
        @error('password')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input  type="password" name="password_confirmation" placeholder="confirm password" value="">
        <button type="submit">Register</button>
    </form>
</div>

<div class="no_account">
    <div class="register">
    <h3>Already have an account? </h3>
    <a href="{{route('login')}}">sign in</a>
    </div>
</div>


@endsection
