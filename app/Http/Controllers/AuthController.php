<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthController extends Controller
{
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
                return Auth::user()->createToken("Zikub")->accessToken;
            } else {
                return abort(403);
            }
        }
    }

    public function register(Request $request)
    {

    }
}
