<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- css stylesheets -->

    <link href="{{ asset('/css/main.css') }}" rel="stylesheet"> 
    <link href="{{ asset('/css/header.css') }}" rel="stylesheet"> 
    <link href="{{ asset('/css/search.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/container.css') }}" rel="stylesheet">

    <!-- Login css Stylesheets -->
    <link href="{{ asset('/css/login_form.css') }}" rel="stylesheet">
    
    <!-- Home css Stylesheets -->
    <link href="{{ asset('/css/post.css') }}" rel="stylesheet"> 
    <link href="{{ asset('/css/sidebar.css') }}" rel="stylesheet"> 
    <link href="{{ asset('/css/new_post.css') }}" rel="stylesheet"> 

    <!-- view_post css Stylesheets -->
    <link href="{{ asset('/css/viewPost.css') }}" rel="stylesheet"> 

    {{-- profile stylesheets --}}
    <link href="{{ asset('/css/profile.css') }}" rel="stylesheet"> 

    {{-- Utility stylesheets --}}
    <link href="{{ asset('/css/dropdown.css') }}" rel="stylesheet">


    <!-- google fonts -->
    <!-- font-family: 'Varela Round', sans-serif; -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/387b30ec20.js" crossorigin="anonymous"></script>

</head>
<body>
    <header>

        <a href="/home"><img class="logo" src="/image/aeedzlogo.svg"></a>

        @if (Auth::user())
        <div class='search_dark header_search_margin'>
            <input type="text" placeholder="search">
        </div>
        @endif
            
        @if (Auth::user())
        <nav class="nav_links">
            <ul>
                <li><a href="/home"><i class="fas fa-home"></i></a></li>
                <li><a href="#"><i class="far fa-envelope"></i></a></li>
                <li><a href="#"><i class="far fa-bell"></i></a></li>
            </ul>


            <div class="more_options">
                <img src="{{ Auth::user()->profile_picture }}" alt="">
                <div class="dropdown_content">
                    <a href="/profile/{{Auth::user()->id}}">Profile</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                        @csrf
                        <button>Log out</button>
                    </form>
                </div>
            </div>
        </nav>
        @endif

    </header>

    <div class="spacer_for_header"></div>

    <div class="container">
    @yield('content')
    </div>

    <footer>

    </footer>
</body>
</html>