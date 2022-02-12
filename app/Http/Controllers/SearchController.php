<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Database\Seeders\UserSeeder;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Repost;

class SearchController extends Controller
{
    public function search_result(Request $request){

        if($request->search == ""){
            $search_users = null;
        }else{
            $search_users = User::where('name', 'LIKE', '%'. $request->search . '%')->get();
        }

        return response()->json([
            'search_users' => $search_users
        ]);
        
    }
}
