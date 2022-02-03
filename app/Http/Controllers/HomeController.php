<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\UserSeeder;

class HomeController extends Controller
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

    public function index()
    {
        $posts = Post::orderby('created_at', 'desc')->get();
        $users = User::all();

        $popular_posts = Post::orderby('likes', 'desc')->take(5)->get();

        return view('home', ['posts'=>$posts, 'popular_posts'=>$popular_posts, 'users'=> $users]);
    }

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
}
