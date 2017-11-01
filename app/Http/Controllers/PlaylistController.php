<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    /**
     * Obtient la playlist de l'utilisateur actuel.
     *
     * @param Request $request
     * @return \Response
     */
    public function get(Request $request)
    {
        return $request->user()->playlist()->with("musics")->first();
    }
}
