<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Follow;

use App\Models\Like;
use App\Models\Favorite;
use App\Models\Repost;
use Laravel\Ui\Presets\React;

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

use phpDocumentor\Reflection\Types\Null_;

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

        $posts =[];
        $user_posts = Post::where('user_id',$id)->orderby('created_at', 'desc')->get();
        $user_reposts = Repost::where('user_id',$id)->where('reposted',1)->orderby('updated_at','desc')->get();

        //following info
        $follow = Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $id)->first();
        $followers = Follow::Where('following_id', $id)->Where('followed', 1)->count();
        $following = Follow::Where('follower_id', $id)->Where('followed', 1)->count();

        $post_comments_count = [];
        $time_stamps = [];

        $post_favorites = [];
        $post_likes = [];
        $post_reposts = [];

        $post_favorites_count = [];
        $post_likes_count = [];
        $post_reposts_count = [];

        // check if following this user or not
        // if the profile belongs to the authenticated user dont make follow table [avoid following yourself]
            if(Auth::user()->id == $id){
                //profile belongs to the authenticated so skip
            }
            else{
                if(Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $id)->count() > 0){
                    //profile follow database items already exists
                }
                else{
                    $follow = new Follow();
                    $follow -> fill([
                        'following_id' => $id,
                        'follower_id' => Auth::user()->id
                    ])->save();
                    $followers = Follow::Where('following_id', $id)->Where('followed', 1)->count();
                    $following = Follow::Where('follower_id', $id)->Where('followed', 1)->count();
                }
            }

        for($i = 0; $i < $user_posts->count(); $i++){

            array_push($time_stamps, get_timestamps($user_posts[$i]->created_at));

            //make Like item in the database
            if(Like::Where('user_id', Auth::user()->id)->Where('post_id', $user_posts[$i]->id)->count() > 0){
                //profile follow database items already exists
            }
            else{
                $like = new Like();
                $like -> fill([
                    'user_id' => Auth::user()->id,
                    'post_id' => $user_posts[$i]->id
                ])->save();
            }
            
            $likes = Like::Where('post_id', $user_posts[$i]->id)->where('user_id', Auth::user()->id)->get();
            array_push($post_likes, $likes);
            
            //make Favorite item in the database
            if(Favorite::Where('user_id', Auth::user()->id)->Where('post_id', $user_posts[$i]->id)->count() > 0){
                //profile follow database items already exists
            }
            else{
                $favorite = new Favorite();
                $favorite -> fill([
                    'user_id' => Auth::user()->id,
                    'post_id' => $user_posts[$i]->id
                ])->save();
            }
            
            $favorites = Favorite::Where('post_id', $user_posts[$i]->id)->where('user_id', Auth::user()->id)->get();
            array_push($post_favorites, $favorites);
            
            //make Repost item in the database
            if(Repost::Where('user_id', Auth::user()->id)->Where('post_id', $user_posts[$i]->id)->count() > 0){
                //profile follow database items already exists
            }
            else{
                $repost = new Repost();
                $repost -> fill([
                    'user_id' => Auth::user()->id,
                    'post_id' => $user_posts[$i]->id
                ])->save();
            }
            
            $repost = Repost::Where('post_id', $user_posts[$i]->id)->where('user_id', Auth::user()->id)->get();
            array_push($post_reposts, $repost);
            
            
            //getting int amounts of LIKES/FAVORITES/REPOSTS/COMMENTS
            $comments = Comment::where('post_id',$user_posts[$i]->id)->get();
            array_push($post_comments_count, $comments->count());

            $likes = Like::Where('post_id', $user_posts[$i]->id)->Where('liked', 1)->count();
            array_push($post_likes_count, $likes);
            
            $favorites = Favorite::Where('post_id', $user_posts[$i]->id)->Where('favorited', 1)->count();
            array_push($post_favorites_count, $favorites);
            
            $reposts = Repost::Where('post_id', $user_posts[$i]->id)->Where('reposted', 1)->count();
            array_push($post_reposts_count, $reposts);

            //push post to the $posts array
            $posts_setup = [];
            array_push($posts_setup, $user_posts[$i], 0, $user_posts[$i]->updated_at);
            array_push($posts, $posts_setup);
        }

        // for($i = 0; $i < $user_reposts->count(); $i++){
        //     $post = Post::where('id', $user_reposts[$i]->post_id)->get();
        //     array_push($time_stamps, get_timestamps($post[0]->created_at));

        //     //make Like item in the database
        //     if(Like::Where('user_id', Auth::user()->id)->Where('post_id', $post[0]->id)->count() > 0){
        //         //profile follow database items already exists
        //     }
        //     else{
        //         $like = new Like();
        //         $like -> fill([
        //             'user_id' => Auth::user()->id,
        //             'post_id' => $post[0]->id
        //         ])->save();
        //     }
            
        //     $likes = Like::Where('post_id', $post[0]->id)->where('user_id', Auth::user()->id)->get();
        //     array_push($post_likes, $likes);
            
        //     //make Favorite item in the database
        //     if(Favorite::Where('user_id', Auth::user()->id)->Where('post_id', $post[0]->id)->count() > 0){
        //         //profile follow database items already exists
        //     }
        //     else{
        //         $favorite = new Favorite();
        //         $favorite -> fill([
        //             'user_id' => Auth::user()->id,
        //             'post_id' => $post[0]->id
        //         ])->save();
        //     }
            
        //     $favorites = Favorite::Where('post_id', $post[0]->id)->where('user_id', Auth::user()->id)->get();
        //     array_push($post_favorites, $favorites);
            
        //     //make Repost item in the database
        //     if(Repost::Where('user_id', Auth::user()->id)->Where('post_id', $post[0]->id)->count() > 0){
        //         //profile follow database items already exists
        //     }
        //     else{
        //         $repost = new Repost();
        //         $repost -> fill([
        //             'user_id' => Auth::user()->id,
        //             'post_id' => $post[0]->id
        //         ])->save();
        //     }
            
        //     $repost = Repost::Where('post_id', $post[0]->id)->where('user_id', Auth::user()->id)->get();
        //     array_push($post_reposts, $repost);
            
            
        //     //getting int amounts of LIKES/FAVORITES/REPOSTS/COMMENTS
        //     $comments = Comment::where('post_id',$post[0]->id)->get();
        //     array_push($post_comments_count, $comments->count());

        //     $likes = Like::Where('post_id', $post[0]->id)->Where('liked', 1)->count();
        //     array_push($post_likes_count, $likes);
            
        //     $favorites = Favorite::Where('post_id', $post[0]->id)->Where('favorited', 1)->count();
        //     array_push($post_favorites_count, $favorites);
            
        //     $reposts = Repost::Where('post_id', $post[0]->id)->Where('reposted', 1)->count();
        //     array_push($post_reposts_count, $reposts);

        //     //push post to the $posts array
        //     $posts_setup = [];
        //     array_push($posts_setup, $post[$i], 1, $post[$i]->updated_at);
        //     array_push($posts, $posts_setup);
        // }

        return view('profile/profile', ['user'=>$user,
                                        'posts'=>$posts, 
                                        'post_comments_count' => $post_comments_count, 
                                        'time_stamps' => $time_stamps, 
                                        'follow' => $follow,
                                        'following' => $following,
                                        'followers' => $followers,
                                        'post_likes' => $post_likes, 
                                        'post_favorites' => $post_favorites,
                                        'post_reposts' => $post_reposts,
                                        'post_favorites_count' => $post_favorites_count,
                                        'post_likes_count' => $post_likes_count,
                                        'post_reposts_count' => $post_reposts_count
        ]);
    }

    public function view_comments($id){

        $comments = Comment::where('user_id',$id)->orderby('created_at', 'desc')->get();
        $posts = [];
        $post_users = [];

        //following info
        $follow = Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $id)->first();
        $followers = Follow::Where('following_id', $id)->Where('followed', 1)->count();
        $following = Follow::Where('follower_id', $id)->Where('followed', 1)->count();

        $post_comments_count = [];
        $time_stamps = [];
        $comment_time_stamps = [];

        $post_favorites = [];
        $post_likes = [];
        $post_reposts = [];

        $post_favorites_count = [];
        $post_likes_count = [];
        $post_reposts_count = [];

        //create profile follower and following counts if first time viewing this profile

            if(Auth::user()->id == $id){
                //profile belongs to the authenticated so skip
            }
            else{
                if(Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $id)->count() > 0){
                    //profile follow database items already exists
                }
                else{
                    $follow = new Follow();
                    $follow -> fill([
                        'following_id' => $id,
                        'follower_id' => Auth::user()->id
                    ])->save();
                    $followers = Follow::Where('following_id', $id)->Where('followed', 1)->count();
                    $following = Follow::Where('follower_id', $id)->Where('followed', 1)->count();
                    $follow = Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $id)->first();
                }
            }

        //fill $posts array with posts user has commented on and $post_users array with users of said posts
            for($i=0; $i<$comments->count(); $i++){

                $post = Post::Where('id', $comments[$i]->post_id)->first();
                $user = User::Where('id', $post->user_id)->first();

                array_push($comment_time_stamps, get_timestamps($comments[$i]->created_at));
                array_push($posts, $post);
                array_push($post_users, $user);
            }

        //getting  data about posts with user comments. {likes, comments, favs, timestamps}
        for($i=0; $i<count($posts); $i++){
            array_push($time_stamps, get_timestamps($posts[$i]->created_at));
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
        
        
            //getting int amounts of LIKES/FAVORITES/REPOSTS/Comments

            $post_comments = Comment::where('post_id',$posts[$i]->id)->get();
            array_push($post_comments_count, $post_comments->count());

            $likes = Like::Where('post_id', $posts[$i]->id)->Where('liked', 1)->count();
            array_push($post_likes_count, $likes);
        
            $favorites = Favorite::Where('post_id', $posts[$i]->id)->Where('favorited', 1)->count();
            array_push($post_favorites_count, $favorites);
        
            $reposts = Repost::Where('post_id', $posts[$i]->id)->Where('reposted', 1)->count();
            array_push($post_reposts_count, $reposts);
        }

        $user = User::find($id);

        return view('profile/comments',['user'=>$user,
                                        'comments'=>$comments,
                                        'posts'=>$posts,
                                        'post_users'=>$post_users,
                                        'follow' => $follow,
                                        'following' => $following,
                                        'followers' => $followers,

                                        'time_stamps' => $time_stamps,
                                        'comment_time_stamps' => $comment_time_stamps,
                                        'post_comments_count' => $post_comments_count, 
                                        'post_likes' => $post_likes, 
                                        'post_favorites' => $post_favorites,
                                        'post_reposts' => $post_reposts,
                                        'post_favorites_count' => $post_favorites_count,
                                        'post_likes_count' => $post_likes_count,
                                        'post_reposts_count' => $post_reposts_count,
        ]);
    }

    public function view_bookmarks($id){
        
        //getting all posts user has bookmarked
            $favorites = Favorite::Where('user_id',$id)->where('favorited',1)->orderby('updated_at','desc')->get();

        //following info for user profile
            $follow = Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $id)->first();
            $followers = Follow::Where('following_id', $id)->Where('followed', 1)->count();
            $following = Follow::Where('follower_id', $id)->Where('followed', 1)->count();

        //fill $posts array with posts user has favorited on and $post_users array with authors of said favorited posts
            $posts = [];
            $post_users = [];

            for($i=0; $i<$favorites->count(); $i++){
               $post = Post::Where('id', $favorites[$i]->post_id)->first();
               $user = User::Where('id', $post->user_id)->first();
            
               array_push($posts, $post);
               array_push($post_users, $user);
            }

        //getting  data about posts with user comments. {likes, comments, favs, timestamps}
            $post_comments_count = [];
            $time_stamps = [];

            $post_favorites = [];
            $post_likes = [];
            $post_reposts = [];

            $post_favorites_count = [];
            $post_likes_count = [];
            $post_reposts_count = [];

            for($i=0; $i<count($posts); $i++){

                //getting timestamps for favorited posts
                array_push($time_stamps, get_timestamps($posts[$i]->created_at));

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
            
                //Add like item to an array
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
            
                //Add favorite item to an array
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
            
                //Add repost item to an array
                    $repost = Repost::Where('post_id', $posts[$i]->id)->where('user_id', Auth::user()->id)->get();
                    array_push($post_reposts, $repost);

                //getting int amounts of LIKES/FAVORITES/REPOSTS/COMMENTS
                    $post_comments = Comment::where('post_id',$posts[$i]->id)->get();
                    array_push($post_comments_count, $post_comments->count());

                    $likes = Like::Where('post_id', $posts[$i]->id)->Where('liked', 1)->count();
                    array_push($post_likes_count, $likes);

                    $favorites = Favorite::Where('post_id', $posts[$i]->id)->Where('favorited', 1)->count();
                    array_push($post_favorites_count, $favorites);

                    $reposts = Repost::Where('post_id', $posts[$i]->id)->Where('reposted', 1)->count();
                    array_push($post_reposts_count, $reposts);
            }

            //SELECT CURRENT USER PROFILE
            $user = User::find($id);
        
        return view('profile/bookmarks',['user'=>$user,
                                        'posts'=>$posts,
                                        'post_users'=>$post_users,
                                        'follow' => $follow,
                                        'following' => $following,
                                        'followers' => $followers,

                                        'time_stamps' => $time_stamps,
                                        'post_comments_count' => $post_comments_count, 
                                        'post_likes' => $post_likes, 
                                        'post_favorites' => $post_favorites,
                                        'post_reposts' => $post_reposts,
                                        'post_favorites_count' => $post_favorites_count,
                                        'post_likes_count' => $post_likes_count,
                                        'post_reposts_count' => $post_reposts_count,
        ]);
    }

    public function view_likes($id){
        //getting all posts user has bookmarked
        $likes = Like::Where('user_id',$id)->where('liked',1)->orderby('updated_at','desc')->get();

        //following info for user profile
            $follow = Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $id)->first();
            $followers = Follow::Where('following_id', $id)->Where('followed', 1)->count();
            $following = Follow::Where('follower_id', $id)->Where('followed', 1)->count();

        //fill $posts array with posts user has favorited on and $post_users array with authors of said favorited posts
            $posts = [];
            $post_users = [];

            for($i=0; $i<$likes->count(); $i++){
               $post = Post::Where('id', $likes[$i]->post_id)->first();
               $user = User::Where('id', $post->user_id)->first();
            
               array_push($posts, $post);
               array_push($post_users, $user);
            }

        //getting  data about posts with user comments. {likes, comments, favs, timestamps}
            $post_comments_count = [];
            $time_stamps = [];

            $post_favorites = [];
            $post_likes = [];
            $post_reposts = [];

            $post_favorites_count = [];
            $post_likes_count = [];
            $post_reposts_count = [];

            for($i=0; $i<count($posts); $i++){

                //getting timestamps for favorited posts
                array_push($time_stamps, get_timestamps($posts[$i]->created_at));

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
            
                //Add like item to an array
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
            
                //Add favorite item to an array
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
            
                //Add repost item to an array
                    $repost = Repost::Where('post_id', $posts[$i]->id)->where('user_id', Auth::user()->id)->get();
                    array_push($post_reposts, $repost);

                //getting int amounts of LIKES/FAVORITES/REPOSTS/COMMENTS
                    $post_comments = Comment::where('post_id',$posts[$i]->id)->get();
                    array_push($post_comments_count, $post_comments->count());

                    $likes = Like::Where('post_id', $posts[$i]->id)->Where('liked', 1)->count();
                    array_push($post_likes_count, $likes);

                    $favorites = Favorite::Where('post_id', $posts[$i]->id)->Where('favorited', 1)->count();
                    array_push($post_favorites_count, $favorites);

                    $reposts = Repost::Where('post_id', $posts[$i]->id)->Where('reposted', 1)->count();
                    array_push($post_reposts_count, $reposts);
            }

            //SELECT CURRENT USER PROFILE
            $user = User::find($id);
        
        return view('profile/likes',['user'=>$user,
                                        'posts'=>$posts,
                                        'post_users'=>$post_users,
                                        'follow' => $follow,
                                        'following' => $following,
                                        'followers' => $followers,

                                        'time_stamps' => $time_stamps,
                                        'post_comments_count' => $post_comments_count, 
                                        'post_likes' => $post_likes, 
                                        'post_favorites' => $post_favorites,
                                        'post_reposts' => $post_reposts,
                                        'post_favorites_count' => $post_favorites_count,
                                        'post_likes_count' => $post_likes_count,
                                        'post_reposts_count' => $post_reposts_count,
        ]);
    }
    //Follow / Unfollow User
    public function follow_user(Request $request){
        
        $follow = Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $request->following_id)->first();

        //Follow user if not yet followed
        if($follow->followed == 0){
            Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $request->following_id)->update(['followed' => 1]);
        }

        //Unfollow user if already followed
        if($follow->followed == 1){
            Follow::Where('follower_id', Auth::user()->id)->Where('following_id', $request->following_id)->update(['followed' => 0]);
        }

        return back();
    }
    //EDIT PERSONAL PROFILE DETAILS
    public function edit_profile($id){

        $user = User::find($id);

        if(Auth::user()->id==1 or Auth::user()->id==$id){
            return view('profile.editprofile',['user' => $user]);
        }

        return redirect('profile/'.$id);
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

        if(isset($request->web)){
            $user->fill([
                'website' => $request->web
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
                case '\images\profiles\pictures\default_raiha.png':
                    break;
                default:
                    // $image_name = explode("\\",$user->profile_picture,2);
                    //unlink($user->profile_picture);    
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
                case '\images\profiles\pictures\default_raiha_bg.png':
                    break;
                default:
                    //$image_name = explode("\\",$user->profile_background,2);
                    //unlink($image_name[1]);    
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
