<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // FOR TEST ONLY

    // github,facebook
    private $driver = 'facebook';

    public function socialLogin(Request $request)
    {
        return Socialite::driver($this->driver)->redirect();
    }

    public function redirect()
    {
        $socialLogin = Socialite::driver($this->driver)->user();
        $column = $this->driver.'_id';

        $user = User::updateOrCreate([
            $column =>  $socialLogin->id
        ],[
            $column => $socialLogin->id,
            'name' => $socialLogin->getName() ?? $socialLogin->nickname,
            'email' => $socialLogin->getEmail(),
            'password' => Hash::make('password')
        ]);
        
        Auth::login($user, true); 
        dd($socialLogin);
    }
}
