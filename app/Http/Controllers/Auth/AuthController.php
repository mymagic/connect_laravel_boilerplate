<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Connect;
use App\User;
use Auth;

class AuthController extends Controller
{
    public static function login(Request $request){
        Connect::init($request);
        $user = User::where('email', '=', Connect::getEmail())->first();

        if ($user === null) {
            User::updateOrCreate([
                'name' => Connect::getFirstName()." ".Connect::getLastName(),
                'email' => Connect::getEmail(),
                'password' => bcrypt(str_random(8)),
            ]);
        }

        $user = User::where('email', '=', Connect::getEmail())->first();

        if (Auth::loginUsingId($user->id,true)) {
            return redirect()->intended('/');
        }
    }
}