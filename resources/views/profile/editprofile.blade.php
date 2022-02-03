@extends('layouts.layout')

@section('content')

    <link href="{{ asset('/css/edit_profile.css') }}" rel="stylesheet"> 
    
    <div class="edit_profile_container">

        <div class="edit_profile_title">
            <i class="fas fa-sliders-h"></i>
            <h2>Edit Profile</h2>
        </div>

        <div class="edit_profile_item">
            <div class="edit_profile_item_details">
                <i class="far fa-user"></i>
                <h2>Profile</h2>
            </div>
            
            <div class="edit_profile_item_input">
                <form  method="POST" action="/profile/edit/details">
                    @csrf
                    <div class="edit_profile_item_input_form profile_spacing_top">
                        <div class="label ">username</div>
                        <input type="text" placeholder="{{$user->name}}" name="name">
                        <div class="edit_profile_item_placeholder"></div>
                    </div>

                    <div class="profile_spacing"></div>

                    <div class="edit_profile_item_input_form">
                        <div class="label">Twitter</div>
                        <input type="text" placeholder="Twitter handle - 'user'" name="twitter">
                        <div class="edit_profile_item_placeholder"></div>
                    </div>
                    <div class="edit_profile_item_input_form">
                        <div class="label">Discord</div>
                        <input type="text" placeholder="Discord handle - 'user#1234'" name="discord">
                        <div class="edit_profile_item_placeholder"></div>
                    </div>
                    <div class="edit_profile_item_input_form">
                        <div class="label">instagram</div>
                        <input type="text" placeholder="instagram handle - 'user'" name="instagram">
                        <div class="edit_profile_item_placeholder"></div>
                    </div>

                    <div class="profile_spacing "></div>
    
                    <div class="edit_profile_item_input_button profile_spacing_bot">
                        <div class="label"></div>
                        <button type="submit">
                            <p>Update</p>
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                    <input type="hidden" value="{{$user->id}}" name='user_id'>
                </form>
            </div>
        </div>

        <div class="edit_profile_item">
            <div class="edit_profile_item_details">
                <i class="fas fa-image"></i>
                <h2>media</h2>
            </div>
            <div class="edit_profile_item_input">
                <form method="POST" action="/profile/edit/media" enctype="multipart/form-data">
                    @csrf
                    <div class="edit_profile_item_input_form profile_spacing_top">
                        <div class="label "></div>
                        <div class="edit_profile_middle">
                            <h3>Profile picture</h3>
                            <img src="{{$user->profile_picture}}" alt="">
                            
                            <label for="profile_picture">
                                <p>Upload</p>
                                <i class="fas fa-file-upload"></i> 
                            </label>

                            <p>nsfw სურათის დამყენებელს ვნახავ მე ბიბლიოთეკასთან</p>
                            <input type="file" name='pfp' id='profile_picture'>
                        </div>
                        <div class="edit_profile_item_placeholder"></div>
                    </div>

                    <div class="profile_spacing "></div>

                    <div class="edit_profile_item_input_form">
                        <div class="label "></div>
                        <div class="edit_profile_middle">
                            <h3>Profile backdrop</h3>
                            <img src="{{$user->profile_background}}" alt="">

                            <label for="profile_background">
                                <p>Upload</p>
                                <i class="fas fa-file-upload"></i> 
                            </label>

                            <p>nsfw სურათის დამყენებელს ვნახავ მე ბიბლიოთეკასთან</p>
                            <input type="file" name='bg' id='profile_background'>
                        </div>
                        <div class="edit_profile_item_placeholder"></div>
                    </div>

                    <div class="profile_spacing "></div>

                    <div class="edit_profile_item_input_button profile_spacing_bot">
                        <div class="label"></div>
                        <button type="submit">
                            <p>Update</p>
                            <i class="fas fa-check"></i>
                        </button>
                    </div>

                    <input type="hidden" value="{{$user->id}}" name='user_id'>
                </form>
            </div>
        </div>

        
        <div class="edit_profile_item">
            <div class="edit_profile_item_details">
                <i class="fa fa-pencil"></i>
                <h2>Bio</h2>
            </div>
            <div class="edit_profile_item_input">
                <form method="POST" action="/profile/edit/bio">
                    @csrf
                    <div class="edit_profile_item_input_form profile_spacing_top">
                        <div class="label">Bio</div>
                        <input type="text" placeholder="{{$user->bio}}" name="bio">
                        <div class="edit_profile_item_placeholder"></div>
                    </div>

                    <div class="profile_spacing "></div>

                    <div class="edit_profile_item_input_button profile_spacing_bot">
                        <div class="label"></div>
                        <button type="submit">
                            <p>Update</p>
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                    <input type="hidden" value="{{$user->id}}" name='user_id'>
                </form>
            </div>
        </div>


    </div>

@endsection