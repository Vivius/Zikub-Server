<?php

namespace App\Http\Controllers;

use App\Music;
use App\Playlist;
use Illuminate\Http\Request;
use Validator;
use Gate;

class MusicController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    /**
     * Permet d'ajouter une nouvelle musique à la playliste de l'utilisateur actuel.
     * Si une musique existe déjà pour le 'rank' demandé elle sera supprimée automatiquement.
     *
     * @param Request $request
     * @return \Response
     */
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "author" => "required",
            "cover" => "required",
            "url" => "required",
            "rank" => "required|numeric",
            "playlist_id" => "required|numeric"
        ]);

        if($validator->fails()) {
            return abort(400);
        } else {
            $playlist = $request->user()->playlists()->orderBy("created_at", "desc")->first();
            if(Gate::allows('musics.post', $playlist)) {
                $playlist->musics()->where("rank", $request->rank)->delete();
                return Music::create([
                    "title" => $request->title,
                    "author" => $request->author,
                    "cover" => $request->cover,
                    "url" => $request->url,
                    "rank" => $request->rank,
                    "playlist_id" => $playlist->id
                ]);
            } else {
                return abort(403);
            }
        }
    }

    /**
     * Supprime une musique et calcul les nouveaux 'rank' de la playliste associée.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $music = Music::find($id);
        $playlist = Playlist::find($music->playlist_id);
        if(Gate::allows('musics.delete', $music)) {
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
