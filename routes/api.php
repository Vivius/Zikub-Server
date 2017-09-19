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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Tests
Route::get("/test", "TestController@methodGET");
Route::post("/test", "TestController@methodPOST");
Route::delete("/test", "TestController@methodDELETE");
Route::put("/test", "TestController@methodPUT");
Route::patch("/test", "TestController@methodPATCH");