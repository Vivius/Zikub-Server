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

// Youtube
Route::get("youtube/search/{query}", "YoutubeApiController@search");

// Playlist
Route::get("playlists/current", "PlaylistController@current");
Route::get("playlists/{id}", "PlaylistController@get");
Route::put("playlists/{id}", "PlaylistController@update");
Route::post("playlists", "PlaylistController@create");

// Music
Route::post("musics", "MusicController@create");
Route::delete("musics/{id}", "MusicController@delete");

// Tests
Route::get("test", "TestController@methodGET");
Route::post("test", "TestController@methodPOST");
Route::delete("test", "TestController@methodDELETE");
Route::put("test", "TestController@methodPUT");
Route::patch("test", "TestController@methodPATCH");

Route::get("toto", function() {
    $music = \App\Music::find(11);
    return $music->playlist()->first()->user_id;
});