<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function view_profile($id){

        $user = User::find($id);
        $posts = Post::where('user_id',$id)->orderby('created_at', 'desc')->get();

        return view('profile/profile', ['user'=>$user, 'posts'=>$posts]);
    }

    public function view_profile_comments($id){
        $user = User::find($id);
        $posts = Post::where('user_id',$id)->get();
        $comments = Comment::where('user_id',$id)->get();

        $posts_list = [];
        $op_list=[];

        for($i = 0; $i < $comments->count(); $i++){
            
            $post = Post::find($comments[$i]->post_id);
            array_push($posts_list, $post);

        }
        for($i = 0; $i < sizeof($posts_list); $i++){

            $user_list = User::find($posts_list[$i]->user_id);
            array_push($op_list, $user_list);
        }

        return view('profile/comments', ['user'=>$user, 'posts_list' => $posts_list, 'users'=>$op_list, 'posts'=>$posts, 'comments'=>$comments]);
    }

    public function edit_profile($id){

        $user = User::find($id);
        if(Auth::user()->id != $id){
            return redirect('home');
        }

        return view('profile.editprofile',['user' => $user]);

    }

    public function profile_edit_details(Request $request){

        $user = User::find($request->user_id);

        if(isset($request->name)){
            $user->fill([
                'name' => $request->name
            ])->save();
        }

        if(isset($request->twitter)){
            $user->fill([
                'twitter' => $request->twitter
            ])->save();
        }

        if(isset($request->discord)){
            $user->fill([
                'discord' => $request->discord
            ])->save();
        }

        if(isset($request->instagram)){
            $user->fill([
                'instagram' => $request->instagram
            ])->save();
        }

        return redirect('/profile/'.$user->id."/edit");
    }

    public function profile_edit_media(Request $request){
        $user = User::find($request->user_id);

        // dd($request);

        if(isset($request->pfp)){
            $pfp = $request->file('pfp');
            $new_pfp_name = time() ."-". $user->name .".". $pfp->extension();
            $pfp->move('images/profiles/pictures', $new_pfp_name);

            switch ($user->profile_picture) {
                case '\images\profiles\pictures\default_ichika.png':
                    break;
                case '\images\profiles\pictures\default_itsuki.png':
                    break;
                case '\images\profiles\pictures\default_miku.png':
                    break;
                case '\images\profiles\pictures\default_nino.png':
                    break;
                case '\images\profiles\pictures\default_yotsuba.png':
                    break;
                default:
                    $image_name = explode("\\",$user->profile_picture,2);
                    unlink($image_name[1]);    
                break;
            }

            $user->fill([
                'profile_picture' => '\images\profiles\pictures\\'.$new_pfp_name
            ])->save();
        }

        if(isset($request->bg)){
            $bg = $request->file('bg');
            $new_bg_name = time() . '-' . $user->name . '.' . $bg->extension();
            $bg -> move('images/profiles/backgrounds', $new_bg_name);

            switch ($user->profile_background) {
                case '\images\profiles\backgrounds\default_ichika_bg.png':
                    break;
                case '\images\profiles\backgrounds\default_itsuki_bg.png':
                    break;
                case '\images\profiles\backgrounds\default_miku_bg.png':
                    break;
                case '\images\profiles\backgrounds\default_nino_bg.png':
                    break;
                case '\images\profiles\backgrounds\default_yotsuba_bg.png':
                    break;
                default:
                    $image_name = explode("\\",$user->profile_background,2);
                    unlink($image_name[1]);    
                break;
            }

            $user->fill([
                'profile_background' => '\images\profiles\backgrounds\\'.$new_bg_name
            ])->save();

        }

        return redirect('/profile/'.$user->id."/edit");
    }

    public function profile_edit_bio(Request $request){

        $user = User::find($request->user_id);

        if(isset($request->bio)){
            $user->fill([
                'bio' => $request->bio 
            ])->save();
        }

        return redirect('/profile/'.$user->id."/edit");
    }
}
