<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //create comment
    public function new_comment(Request $request){

        $request->validate([
            'comment' => 'max:300',
        ]);

        $user = User::find($request['user_id']);
        $post = Post::find($request['post_id']);
        $comment = new Comment();

        $comment -> fill([
            'comment' => $request['comment'],
            'user_id' => $request['user_id'],
            'post_id' => $request['post_id']
        ])->save();

        if(isset($request->comment_image)){
            $image = $request->file('comment_image');
            $newImageName = time() . '_' . $user->name . '.' . $image->extension();
            $image->move('images/comments', $newImageName);

            $comment -> fill([
                'image' =>'\images\comments\\'. $newImageName 
            ])->save();
        }

        return redirect('/post/'.$post['id']);
    }

    //delete comment
    public function delete_comment(Request $request){
        $comment = Comment::find($request->comment_id);

        $comment -> Delete();

        return redirect('/post/'.$request->post_id);
    }
}
