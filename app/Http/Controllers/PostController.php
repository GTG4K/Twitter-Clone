<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Like;
use App\Models\Repost;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view_post($id){
        $post = Post::find($id);
        $comments = Comment::where('post_id', $id)->get();

        $post_author = User::find($post->user_id);
        $comment_authors = [];
        $comment_time_stamps = [];
        $post_time_stamp = [];

        $post_favorites = [];
        $post_likes = [];
        $post_reposts = [];

        $post_favorites_count = [];
        $post_likes_count = [];
        $post_reposts_count = [];

        //getting timestamps
        for($i=0; $i<$comments->count(); $i++){
            //getting comment
            $comment = Comment::find($comments[$i]->id);

            //getting commenters usernames
            $user = User::find($comments[$i]->user_id);
            array_push($comment_authors, $user);

            // getting time
            $created_at = $comment->created_at;
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

            $day_split = explode('0', $month_split[1]);
            array_push($time_stamp, $month, $day_split[1],  $year_split[0]);
            array_push($comment_time_stamps, $time_stamp);          
        }   

        // getting post timestamp
        $created_at = $post->created_at;
        $split_created_at = explode(" ", $created_at);
        $day = $split_created_at[0];
        $time = $split_created_at[1];
        $time_stamp = [];
        $year_split = explode("-", $day,2);
        $month_split = explode('-',$year_split[1]);
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
        $day_split = explode('0', $month_split[1]);
        array_push($time_stamp, $month, $day_split[1],  $year_split[0]);
        array_push($post_time_stamp, $time_stamp);                                
        // end getting timestamp

        //make Like item in the database
        if(Like::Where('user_id', Auth::user()->id)->Where('post_id', $post->id)->count() > 0){
            //profile follow database items already exists
            }
            else{
                $like = new Like();
                $like -> fill([
                    'user_id' => Auth::user()->id,
                    'post_id' => $post->id
                ])->save();
            }
            
            $likes = Like::Where('post_id', $post->id)->get();
            array_push($post_likes, $likes);
            
            //make Favorite item in the database
            if(Favorite::Where('user_id', Auth::user()->id)->Where('post_id', $post->id)->count() > 0){
                //profile follow database items already exists
            }
            else{
                $favorite = new Favorite();
                $favorite -> fill([
                    'user_id' => Auth::user()->id,
                    'post_id' => $post->id
                ])->save();
            }
            
            $favorites = Favorite::Where('post_id', $post->id)->get();
            array_push($post_favorites, $favorites);
            
            //make Repost item in the database
            if(Repost::Where('user_id', Auth::user()->id)->Where('post_id', $post->id)->count() > 0){
                //profile follow database items already exists
            }
            else{
                $repost = new Repost();
                $repost -> fill([
                    'user_id' => Auth::user()->id,
                    'post_id' => $post->id
                ])->save();
            }
            
            $repost = Repost::Where('post_id', $post->id)->get();
            array_push($post_reposts, $repost);
            
            
            //getting int amounts of LIKES/FAVORITES/REPOSTS
            $likes = Like::Where('post_id', $post->id)->Where('liked', 1)->count();
            array_push($post_likes_count, $likes);
            
            $favorites = Favorite::Where('post_id', $post->id)->Where('favorited', 1)->count();
            array_push($post_favorites_count, $favorites);
            
            $reposts = Repost::Where('post_id', $post->id)->Where('reposted', 1)->count();
            array_push($post_reposts_count, $reposts);

        return view('viewpost', ['post' => $post,
                                'comments' => $comments, 
                                'comment_time_stamps' => $comment_time_stamps,
                                'post_time_stamp' => $post_time_stamp,
                                'comment_authors' => $comment_authors,
                                'post_author' => $post_author,
                                'post_likes' => $post_likes, 
                                'post_favorites' => $post_favorites,
                                'post_reposts' => $post_reposts,
                                'post_favorites_count' => $post_favorites_count,
                                'post_likes_count' => $post_likes_count,
                                'post_reposts_count' => $post_reposts_count
        ]);
    }
    
    // Create Post
    public function new_post(Request $request){

        $request->validate([
            'description' => 'max:300'
        ]);

        $user = User::find($request['user_id']);
        $post = new Post;

        $post -> fill([
            'description' => $request['description'],
            'user_id' => $request['user_id']
        ])->save();

        if(isset($request->image)){
            $image = $request->file('image');
            $newImageName = time() . '-' . $user['name'] . '.' . $image->extension();
            $image->move('images/posts', $newImageName);

            $post -> fill([
                'image' => '\images\posts\\'.$newImageName,
            ])->save();
        }

                return back();
    }

    public function like_post(Request $request){
        $like = Like::Where('post_id', $request->post_id)->where('user_id', $request->user_id)->first();
        //Follow user if not yet followed
        if($like->liked == 0){
            Like::Where('post_id', $request->post_id)->where('user_id', $request->user_id)->update(['liked' => 1]);
        }

        //Unfollow user if already followed
        if($like->liked == 1){
            Like::Where('post_id', $request->post_id)->where('user_id', $request->user_id)->update(['liked' => 0]);
        }

        return back();
    }

    public function repost_post(Request $request){
        $repost = Repost::Where('post_id', $request->post_id)->where('user_id', $request->user_id)->first();

        //Follow user if not yet followed
        if($repost->reposted == 0){
            Repost::Where('post_id', $request->post_id)->where('user_id', $request->user_id)->update(['reposted' => 1]);
        }

        //Unfollow user if already followed
        if($repost->reposted == 1){
            Repost::Where('post_id', $request->post_id)->where('user_id', $request->user_id)->update(['reposted' => 0]);
        }

        return back();
    }

    public function favorite_post(Request $request){
        $favorite = Favorite::Where('post_id', $request->post_id)->where('user_id', $request->user_id)->first();

        //Follow user if not yet followed
        if($favorite->favorited == 0){
            Favorite::Where('post_id', $request->post_id)->where('user_id', $request->user_id)->update(['favorited' => 1]);
        }

        //Unfollow user if already followed
        if($favorite->favorited == 1){
            Favorite::Where('post_id', $request->post_id)->where('user_id', $request->user_id)->update(['favorited' => 0]);
        }

        return back();
    }

    // Delete Post
    public function delete_post(Request $request){
        $post = Post::find($request->post_id);
        $image = $post->image;

        if ($image) {
            //$image_name = explode("\\",$image,2);
            //unlink($image_name[1]);
        }

        $post->delete();

        return redirect('/home');
    }
}
