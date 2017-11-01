<?php

namespace App\Http\Controllers;

use App\Music;
use App\Playlist;
use Illuminate\Http\Request;
use Validator;

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
        return $request->user()->playlists()->orderBy("created_at", "desc")->with("musics")->first();
    }

    /**
     * Crée une nouvelle playliste.
     *
     * @param Request $request
     */
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "description" => "required",
        ]);

        if($validator->fails()) {
            return abort(400);
        } else {
            $playlist = Playlist::create([
                "name" => $request->name,
                "description" => $request->description,
                "user_id" => $request->user()->id
            ]);

            // Ajoute les musiques de l'ancienne playliste à la nouvelle playliste.
            $playlists = $request->user()->playlists()->orderBy("created_at", "desc")->get();
            if(count($playlists) > 1) {
                foreach ($playlists[1]->musics()->get() as $music) {
                    Music::create([
                        "title" => $music->title,
                        "author" => $music->author,
                        "cover" => $music->cover,
                        "url" => $music->url,
                        "rank" => $music->rank,
                        "playlist_id" => $playlist->id
                    ]);
                }
            }

            return $playlist;
        }
    }
}
