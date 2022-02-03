<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $rand_quint = rand(0,4);
        switch ($rand_quint) {
            case 0:
                $pfp = '\images\profiles\pictures\default_ichika.png';
                $bg =  '\images\profiles\backgrounds\default_ichika_bg.png';
                break;
            case 1:
                $pfp = '\images\profiles\pictures\default_itsuki.png';
                $bg =  '\images\profiles\backgrounds\default_itsuki_bg.png';
                break;
            case 2:
                $pfp = '\images\profiles\pictures\default_miku.png';
                $bg =  '\images\profiles\backgrounds\default_miku_bg.png';
                break;
            case 3:
                $pfp = '\images\profiles\pictures\default_nino.png';
                $bg =  '\images\profiles\backgrounds\default_nino_bg.png';
                break;    
            case 4:
                $pfp = '\images\profiles\pictures\default_yotsuba.png';
                $bg =  '\images\profiles\backgrounds\default_yotsuba_bg.png';
                break; 
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

            'profile_picture' => $pfp,
            'profile_background' => $bg
        ]);
    }
}
