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

// Resources routes
Route::resource("users", "UserController");

// Tests
Route::get("test", "TestController@methodGET");
Route::post("test", "TestController@methodPOST");
Route::delete("test", "TestController@methodDELETE");
Route::put("test", "TestController@methodPUT");
Route::patch("test", "TestController@methodPATCH");