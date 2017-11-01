<?php

namespace App\Http\Controllers;

use App\Music;
use App\Playlist;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Supprime une musique et calcul les nouveaux rangs de la playliste associée.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $music = Music::find($id);
        $playlist = Playlist::find($music->playlist_id);
        if(\Gate::allows('musics.delete', $music)) {
            $music->delete();
            // Calcul des nouveaux rangs.
            $musics = $playlist->musics()->orderBy("rank")->get();
            $cpt = 1;
            foreach ($musics as $m) {
                if($m->rank > $cpt) {
                    $m->rank = $cpt;
                    $m->save();
                }
                $cpt++;
            }
            return $musics;
        }
        return abort(403);
    }
}
