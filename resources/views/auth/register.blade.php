<?php 
    use App\Models\User;
    $users = User::all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/css/login_form.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/container.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet"> 

    <title> AW - Register </title>
    <link rel = "icon" href = "{{asset('/image/aeedzlogo.svg')}}" type = "image/x-icon">
</head>

<body class="login_page_container">

    <div class='login_container'>

        <div class="login_display">

            <div class="forms_container">
    
                <div class='login_form'>
                    <div class="login_form_logo">
                        <img src="/image/aeedzlogo.svg" alt="">
                        <h2>Hi!</h2>
                    </div>
                    
                    <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf
                        <div class="login_form_inputs">
                            <input  type="text" name="name" placeholder="enter your username">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror 
                            <input  type="email" name="email" placeholder="enter your email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <input  type="password" name="password" placeholder="enter your password" autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <input  type="password" name="password_confirmation" placeholder="confirm password">
                            <button type="submit">Register</button>
                            {{-- <a class="btn btn-link" href="#{{ route('password.request') }}"> Forgot your password? </a> --}}
                        </div>
                    </form>
    
                    <div class="separator">
                        <hr>
                        <h2>OR</h2>
                        <hr>
                    </div>
    
                </div>
    
                
                <div>
                    <div class="register">
                        <a href="{{route('login')}}">sign in</a>
                    </div>
                </div>
            </div>
    
            <div class="login_side">
                <img src="{{asset('/image/aeedz_register_bg.jpg')}}" alt="">
            </div>
        </div>   
    </div>

    
    <div class="bottom_div_for_users">
        <h2>List of legends</h2>
        <div class="users_display">
            @foreach ($users as $user)
                <img src="{{$user->profile_picture}}" alt="">
            @endforeach
        </div>
    </div>

</div> 
</body>
</html>
{{-- <body class="container">
    <div>
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
    </div>
</body> --}}

