<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function methodGET()
    {
        return User::all();
    }

    public function methodPOST(Request $request)
    {
        return $request->all();
    }

    public function methodDELETE()
    {
        return User::all();
    }

    public function methodPUT(Request $request)
    {
        return $request->all();
    }

    public function methodPATCH(Request $request)
    {
        return $request->all();
    }
}
