<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title> AW - {{Auth::user()->name}} </title>
    <link rel = "icon" href = "{{asset('/image/aeedzlogo.svg')}}" type = "image/x-icon">

    <!-- css stylesheets -->
    <link href="{{ asset('/css/container.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet"> 
    <link href="{{ asset('/css/header.css') }}" rel="stylesheet"> 
    <link href="{{ asset('/css/search.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sidebar.css') }}" rel="stylesheet">  

    <!-- view_post css Stylesheets -->
    <link href="{{ asset('/css/viewPost.css') }}" rel="stylesheet"> 

    {{-- profile stylesheets --}}

    {{-- Utility stylesheets --}}
    <link href="{{ asset('/css/dropdown.css') }}" rel="stylesheet">


    <!-- google fonts -->
    {{-- font-family: 'Nunito', sans-serif --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;1,300;1,400&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/387b30ec20.js" crossorigin="anonymous"></script>


</head>
<body>

    <div class="side_navbar">
        <div class="logo_content">
            <div class="logo_content_items">
                <img id="logo" src="/image/aeedzlogo.svg">
                <div class="logo_name">AeedzWeb</div>
            </div>
        </div>
        <i class="fas fa-bars" id='menu_btn'></i>
        <ul class="nav_list">
            <li>
                <a href="/home">
                    <i class="fas fa-home"></i>
                    <span class="link_name"> Home </span>
                </a>
                {{-- <span class="tooltip"> Home </span> --}}
            </li>
            <li>
                <a href="/profile/{{Auth::user()->id}}">
                    <i class="far fa-user"></i>
                    <span class="link_name"> Profile </span>
                </a>
                {{-- <span class="tooltip"> Profile </span> --}}
            </li>
            <li>
                <a href="/profile/{{Auth::user()->id}}/bookmarks">
                    <i class="far fa-bookmark"></i>
                    <span class="link_name"> Bookmarks </span>
                </a>
                {{-- <span class="tooltip"> Bookmarks </span> --}}
            </li>
            <li>
                {{-- <a href="#">
                    <i class="far fa-envelope"></i>
                    <span class="link_name"> Messages </span>
                </a> --}}
                {{-- <span class="tooltip"> Messages </span> --}}
            </li>
            <li>
                {{-- <a href="#">
                    <i class="far fa-bell"></i>
                    <span class="link_name"> Noatifications </span>
                </a> --}}
                {{-- <span class="tooltip"> Noatifications </span> --}}
            </li>
            <li>
                {{-- <a href="#">
                    <i class="fas fa-wallet"></i>
                    <span class="link_name"> Wallet </span>
                </a> --}}
                {{-- <span class="tooltip"> Wallet </span> --}}
            </li>
        </ul>
        <div class="profile_content">
            <div class='additional_options'>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                    @csrf
                    <button>Log out</button>
                </form>
            </div>
            <div class="profile">
                <div class="profile_details">
                    <img src="{{Auth::user()->profile_picture}}" alt="">
                    <div class="profile_details_information">
                        <div class="profile_name">{{Auth::user()->name}}</div>
                    </div>
                </div>
                <i class="fas fa-ellipsis-h"></i>
            </div>
        </div>
    </div>

    <div class="container">
    @yield('content')
    </div>

    <footer>

    </footer>
</body>
</html>

{{-- javascript --}}
<script type="text/javascript" src="{{url('js/search.js')}}"></script>
<script type="text/javascript" src="{{url('js/side_navbar.js')}}"></script>

