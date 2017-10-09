<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentification
Route::post("login", "AuthController@login");
Route::post("register", "AuthController@register");

// User
Route::get("users/current", "UserController@current");
Route::get("playlist/get", "PlaylistController@get");

// Resources routes
Route::resource("users", "UserController");
Route::resource("playlists", "PlaylistController");
Route::resource("musics", "MusicController");

// Tests
Route::get("test", "TestController@methodGET");
Route::post("test", "TestController@methodPOST");
Route::delete("test", "TestController@methodDELETE");
Route::put("test", "TestController@methodPUT");
Route::patch("test", "TestController@methodPATCH");

Route::get("toto", function() {
    return \App\User::find(1)->playlist()->with("musics")->first();
});