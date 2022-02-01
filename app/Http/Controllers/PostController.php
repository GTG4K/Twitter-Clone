<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    public function view_post($id){
        $post = Post::find($id);
        $users = User::all();
        $comments = Comment::where('post_id', $id)->get();
        $popular_posts = Post::orderby('likes', 'desc')->take(5)->get();
    
        return view('viewpost', ['post' => $post, 'popular_posts'=>$popular_posts, 'users' => $users, 'comments' => $comments]);
    }
    
    // Create Post
    public function new_post(Request $request){

        $user = User::find($request['user_id']);
        $post = new Post;

        $post -> fill([
            'author' => $user['name'],
            'description' => $request['description'],
            'user_id' => $request['user_id']
        ])->save();

        if($request->image){
            $image = $request->file('image');

            $newImageName = time() . '-' . $user['name'] . '.' . $image->extension();

            $image->move(public_path('images'), $newImageName);

            $post -> fill([
                'image' => '/images/'.$newImageName
            ])->save();
        }

        return redirect('/home');
    }

    // Delete Post
    public function delete_post(Request $request){
        $post = Post::find($request->post_id);

        $post->delete();

        return redirect('/home');
    }

    //create comment
    public function new_comment(Request $request){

        $user = User::find($request['user_id']);
        $post = Post::find($request['post_id']);
        $comment = new Comment();

        $comment -> fill([
            'author' => $user['name'],
            'comment' => $request['comment'],
            'user_id' => $request['user_id'],
            'post_id' => $request['post_id']
        ])->save();

        return redirect('/post/'.$post['id']);
    }

    //delete comment
    public function delete_comment(Request $request){
        $comment = Comment::find($request->comment_id);

        $comment -> Delete();

        return redirect('/post/'.$request->post_id);
    }

}
