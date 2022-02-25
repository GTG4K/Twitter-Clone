<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Repost;

use function App\Http\Controllers\get_timestamps as ControllersGet_timestamps;

function get_timestamps($created_at){

    //needs array $time_stamps and object created_at data.
    // $created_at = $posts[$i]->created_at;

    //$time_stamps[0] - Month 
    //$time_stamps[1] - Day
    //$time_stamps[2] - Year

    $time_stamps = [];
    $split_created_at = explode(" ", $created_at);
    $day = $split_created_at[0];
    $time = $split_created_at[1];
    $time_stamp = [];
    $year_split = explode("-", $day,2);
    $month_split = explode('-',$year_split[1]);

        //getting month posted
    switch ($month_split[0]) {
        case '01':
            $month = 'Jan ';
            break;
        case '02':
            $month = 'Feb ';
            break;
        case '03':
            $month = 'Mar ';
            break;
        case '04':
            $month = 'Apr ';
            break;
        case '05':
            $month = 'May ';
            break;
        case '06':
            $month = 'Jun ';
            break;
        case '07':
            $month = 'Jul ';
            break;
        case '08':
            $month = 'Aug ';
            break;
        case '09':
            $month = 'Sep ';
            break;
        case '10':
            $month = 'Oct ';
            break;
        case '11':
            $month = 'Nov ';
            break;
        case '12':
            $month = 'Dec ';
            break;
    }
            
    array_push($time_stamp, $month, $month_split[1],  $year_split[0]);
    return $time_stamp;  
}

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

    public function index(){
        $posts = Post::orderby('created_at', 'desc')->get();

        $users = User::all()->take(5);

        $users_follow_details=[];
        for($i = 0; $i < $users->count(); $i++){
            $users_follow=[];

            if(Auth::user()->id == $users[$i]->id){
                //profile belongs to the authenticated so skip
                $followers = Follow::Where('following_id', $users[$i]->id)->Where('followed', 1)->count();
            }
            else{
                if(Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $users[$i]->id)->count() > 0){
                    //profile follow database items already exists
                    $followers = Follow::Where('following_id', $users[$i]->id)->Where('followed', 1)->count();
                }
                else{
                    $follow = new Follow();
                    $follow -> fill([
                        'following_id' => $users[$i]->id,
                        'follower_id' => Auth::user()->id
                    ])->save();
                    $followers = Follow::Where('following_id', $users[$i]->id)->Where('followed', 1)->count();
                }
            }

            

            $follow = Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $users[$i]->id)->first();
            array_push($users_follow, $follow, $followers);
            array_push($users_follow_details, $users_follow);
        }

        // dd($users_follow_details);


        $post_comments_count = [];

        $post_favorites = [];
        $post_likes = [];
        $post_reposts = [];
        $post_favorites_count = [];
        $post_likes_count = [];
        $post_reposts_count = [];

        $post_authors = [];
        $time_stamps = [];

        for($i = 0; $i < $posts->count(); $i++){
            
            //getting usernames
            $post = Post::find($posts[$i]->id);
            $user = User::find($posts[$i]->user_id);
            array_push($post_authors, $user);

            //getting comment
            $comments = Comment::where('post_id',$post->id)->get();
            array_push($post_comments_count, $comments->count());
            
            //getting Timestamps
            array_push($time_stamps, Get_timestamps($post->created_at));     


             //make Like item in the database
             if(Like::Where('user_id', Auth::user()->id)->Where('post_id', $posts[$i]->id)->count() > 0){
                //profile follow database items already exists
            }
            else{
                $like = new Like();
                $like -> fill([
                    'user_id' => Auth::user()->id,
                    'post_id' => $posts[$i]->id
                ])->save();
            }

            $likes = Like::Where('post_id', $posts[$i]->id)->where('user_id', Auth::user()->id)->get();
            array_push($post_likes, $likes);

            //make Favorite item in the database
            if(Favorite::Where('user_id', Auth::user()->id)->Where('post_id', $posts[$i]->id)->count() > 0){
                //profile follow database items already exists
            }
            else{
                $favorite = new Favorite();
                $favorite -> fill([
                    'user_id' => Auth::user()->id,
                    'post_id' => $posts[$i]->id
                ])->save();
            }

            $favorites = Favorite::Where('post_id', $posts[$i]->id)->where('user_id', Auth::user()->id)->get();
            array_push($post_favorites, $favorites);

            //make Repost item in the database
            if(Repost::Where('user_id', Auth::user()->id)->Where('post_id', $posts[$i]->id)->count() > 0){
                //profile follow database items already exists
            }
            else{
                $repost = new Repost();
                $repost -> fill([
                    'user_id' => Auth::user()->id,
                    'post_id' => $posts[$i]->id
                ])->save();
            }

            $repost = Repost::Where('post_id', $posts[$i]->id)->where('user_id', Auth::user()->id)->get();
            array_push($post_reposts, $repost);

            //getting int amounts of LIKES/FAVORITES/REPOSTS
            $likes = Like::Where('post_id', $posts[$i]->id)->Where('liked', 1)->count();
            array_push($post_likes_count, $likes);

            $favorites = Favorite::Where('post_id', $posts[$i]->id)->Where('favorited', 1)->count();
            array_push($post_favorites_count, $favorites);

            $reposts = Repost::Where('post_id', $posts[$i]->id)->Where('reposted', 1)->count();
            array_push($post_reposts_count, $reposts);
        }


        return view('home', ['posts'=>$posts, 
        'post_authors'=> $post_authors, 
        'timestamps'=> $time_stamps, 
        'post_comments_count' =>$post_comments_count, 
        'post_likes' => $post_likes, 
        'post_favorites' => $post_favorites,
        'post_reposts' => $post_reposts,
        'post_favorites_count' => $post_favorites_count,
        'post_likes_count' => $post_likes_count,
        'post_reposts_count' => $post_reposts_count,
        'users_follow_details' => $users_follow_details,
        'users' => $users

    ]);
    }

    public function view_users(){
        $users = User::all();
        $users_follow_details=[];
        for($i = 0; $i < $users->count(); $i++){
            $users_follow=[];

            if(Auth::user()->id == $users[$i]->id){
                //profile belongs to the authenticated so skip
                $followers = Follow::Where('following_id', $users[$i]->id)->Where('followed', 1)->count();
            }
            else{
                if(Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $users[$i]->id)->count() > 0){
                    //profile follow database items already exists
                    $followers = Follow::Where('following_id', $users[$i]->id)->Where('followed', 1)->count();
                }
                else{
                    $follow = new Follow();
                    $follow -> fill([
                        'following_id' => $users[$i]->id,
                        'follower_id' => Auth::user()->id
                    ])->save();
                    $followers = Follow::Where('following_id', $users[$i]->id)->Where('followed', 1)->count();
                }
            }

            

            $follow = Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $users[$i]->id)->first();
            array_push($users_follow, $follow, $followers);
            array_push($users_follow_details, $users_follow);
        }


        return view('users', ['users'=>$users,'users_follow_details'=>$users_follow_details]);
    }
}