<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    /**
     * Retourne l'utilisateur actuellement authentifié.
     *
     * @param Request $request
     * @return Response
     */
    public function current(Request $request)
    {
        return $request->user();
    }
}
