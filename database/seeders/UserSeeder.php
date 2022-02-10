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
            'name' => 'Tarkhna',
            'email' => 'tarkhna@gmail.com',
            'password' => Hash::make('password'),
            'profile_picture' => '\images\profiles\pictures\default_Tarkhna.png',
            'profile_background' => '\images\profiles\backgrounds\default_Tarkhna_bg.gif',
            'bio' => 'Tarkhna Gigachadi'
        ])->save();

        $user = new User;
        $user->fill([
            'name' => 'Misato',
            'email' => 'misato@gmail.com',
            'password' => Hash::make('password'),
            'profile_picture' => '\images\profiles\pictures\default_Tarkhna.png',
            'profile_background' => '\images\profiles\backgrounds\default_Tarkhna_bg.gif',
            'bio' => 'Mommysato Mommussy'
        ])->save();
    }
}
