<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = user::find(1);

        for($i=0; $i<5; $i++){
            $post = new Post();
            
            $post->fill([
                'author'=> $user['name'],
                'user_id' => 1,
                'description' => Str::random(30),
                'image' => 'https://www.wallpapertip.com/wmimgs/65-655970_rem-and-ram-re-zero-rem-and-ram.jpg',
                'likes' => rand(10,1000),
                'views' => rand(1000,10000) 
            ])->save();
        }
    }
}
