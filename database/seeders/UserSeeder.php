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
            'name' => 'Zer02',
            'email' => 'Zer02@gmail.com',
            'password' => Hash::make('password'),
            'profile_picture' => 'https://wallpapercave.com/uwp/uwp1644642.jpeg'
        ])->save();

        $user = new User;
        $user->fill([
            'name' => 'tarkhna',
            'email' => 'tarkhna@gmail.com',
            'password' => Hash::make('password'),
            'profile_picture' => 'https://yt3.ggpht.com/ytc/AKedOLTOULukEPaBheOiLRBb7wLLftHW_8vU9LIC_4jmGHw=s900-c-k-c0x00ffffff-no-rj'
        ])->save();
    }
}
