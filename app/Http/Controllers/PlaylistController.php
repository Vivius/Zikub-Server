<?php

namespace App\Http\Controllers;

use App\Music;
use App\Playlist;
use Illuminate\Http\Request;
use Validator;
use Gate;

class PlaylistController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    /**
     * Obtient la playlist actuelle de l'utilisateur (dernière playliste créée).
     *
     * @param Request $request
     * @return \Response
     */
    public function current(Request $request)
    {
        return $request->user()->playlists()->orderBy("created_at", "desc")->with("musics")->first();
    }

    /**
     * Permet de mettre à jour la playliste demandée.
     *
     * @param Request $request
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "description" => "required",
        ]);

        if($validator->fails()) {
            return abort(400);
        } else {
            $playlist = Playlist::find($id);
            if(Gate::allows('playlists.put', $playlist)) {
                $playlist->update([
                    "name" => $request->name,
                    "description" => $request->description
                ]);
                return $playlist;
            } else {
                return abort(403);
            }
        }
    }

    /**
     * Crée une nouvelle playliste qui se base sur l'ancienne si disponible.
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "description" => "required",
        ]);

        if($validator->fails()) {
            return abort(400);
        } else {
            $newPlaylist = Playlist::create([
                "name" => $request->name,
                "description" => $request->description,
                "user_id" => $request->user()->id
            ]);

            // Ajoute les musiques de l'ancienne playliste à la nouvelle playliste pour que l'utilisateur ait encore accès à ses morceaux.
            $playlists = $request->user()->playlists()->orderBy("created_at", "desc")->get();
            if(count($playlists) > 1) {
                $oldPlaylist = $playlists[1]->musics()->get();
                foreach ($oldPlaylist as $music) {
                    Music::create([
                        "title" => $music->title,
                        "author" => $music->author,
                        "cover" => $music->cover,
                        "url" => $music->url,
                        "rank" => $music->rank,
                        "playlist_id" => $newPlaylist->id
                    ]);
                }
            }

            return $newPlaylist;
        }
    }
}
