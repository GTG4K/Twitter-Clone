<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
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
        $users = User::all();
        $comments = Comment::where('post_id', $id)->get();
        $popular_posts = Post::orderby('likes', 'desc')->take(5)->get();
    
        return view('viewpost', ['post' => $post, 'popular_posts'=>$popular_posts, 'users' => $users, 'comments' => $comments]);
    }
    
    // Create Post
    public function new_post(Request $request){

        $request->validate([
            'description' => 'required',
            'image' => 'required'
        ]);

        $user = User::find($request['user_id']);
        $post = new Post;

        $image = $request->file('image');
        $newImageName = time() . '-' . $user['name'] . '.' . $image->extension();
        $image->move('images/posts', $newImageName);

        $post -> fill([
            'author' => $user['name'],
            'image' => '\images\posts\\'.$newImageName,
            'description' => $request['description'],
            'user_id' => $request['user_id']
        ])->save();

        return redirect('/home');
    }

    // Delete Post
    public function delete_post(Request $request){
        $post = Post::find($request->post_id);
        $image = $post->image;

        if ($image) {
            $image_name = explode("\\",$image,2);
            unlink($image_name[1]);
        }

        $post->delete();

        return redirect('/home');
    }

    //create comment
    public function new_comment(Request $request){

        $request->validate([
            'comment' => 'required',
        ]);

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
