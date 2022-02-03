<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->fill([
            'name' => 'Raiha',
            'email' => 'Raiha@gmail.com',
            'password' => Hash::make('password'),
            'profile_picture' => '\images\profiles\pictures\default_raiha.png',
            'profile_background' => '\images\profiles\backgrounds\default_raiha_bg.jpg',
            'bio' => 'Admin Raiha Girlboss B)'

        ])->save();
    }
}
