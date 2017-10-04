<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    public function index()
    {
        return User::all();
    }

    public function create()
    {
        //
    }

    public function store()
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function current(Request $request) {
        return $request->user();
    }
}
