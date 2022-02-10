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

    <title> AW - Login </title>
    <link rel = "icon" href = "{{asset('/image/aeedzlogo.svg')}}" type = "image/x-icon">
</head>
<body class="login_page_container">

    <div class='login_container'>

        <div class="login_display">

            <div class="forms_container">
    
                <div class='login_form'>
                    <div class="login_form_logo">
                        <img src="/image/aeedzlogo.svg" alt="">
                        <h2>Welcome Back!</h2>
                    </div>
                    
                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                        <div class="login_form_inputs">
                            <input  type="email" name="email" placeholder="enter your email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
    
                            <input  type="password" name="password" placeholder="enter your password"  autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
        
                            <button type="submit">Log in</button>
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
                        <a href="{{route('register')}}">sign up</a>
                    </div>
                </div>
            </div>
    
            <div class="login_side">
                <img src="{{asset('/image/aeedz_login_bg.jpg')}}" alt="">
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


{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

