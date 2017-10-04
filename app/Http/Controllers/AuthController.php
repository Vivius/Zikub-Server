<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthController extends Controller
{
    /**
     * Login the user and returns a new oauth token for the api if success.
     *
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required"
        ]);

        if($validator->fails()) {
            return abort(400);
        } else {
            if(Auth::attempt(["email" => $request->email, "password" => $request->password])) {
                Auth::user()->tokens()->delete(); // Delete the old token (if exists) at each new login.
                return Auth::user()->createToken("Zikub Android")->accessToken;
            } else {
                return abort(403);
            }
        }
    }

    /**
     * Register a new user.
     * If success, returns a oauth token for the api.
     *
     * @param Request $request
     * @return string
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:6",
            "email" => "required|email",
            "password" => "required|min:6|confirmed",
            "password_confirmation" => "required"
        ]);

        if($validator->fails()) {
            return abort(400);
        } else {
           $user = (new User())->create($request->all());
           return $user->createToken("Zikub Android")->accessToken;
        }
    }
}
