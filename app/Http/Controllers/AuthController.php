<?php

namespace App\Http\Controllers;

use App\Playlist;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthController extends Controller
{
    /**
     * Connecte l'utilisateur à l'application en lui retournant un token d'authentification.
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
     * Inscrit un nouvel utilisateur.
     * Si l'opération réussie, un token permanent est retourné.
     *
     * @param Request $request
     * @return string
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:4",
            "email" => "required|email",
            "password" => "required|min:6|confirmed",
            "password_confirmation" => "required"
        ]);

        if($validator->fails()) {
            return abort(400);
        } else {
            $data = $request->all();
            $data["password"] = bcrypt($data["password"]);
            $user = (new User())->create($data);
            Playlist::create([
                "name" => "Première playlist",
                "description" => "En attente de construction...",
                "user_id" => $user->id
            ]);
            return $user->createToken("Zikub Android")->accessToken;
        }
    }
}
