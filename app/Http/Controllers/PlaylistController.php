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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get the playlist of the current user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        return $request->user()->playlist()->with("musics")->first();
    }

    /**
     * Updates the current playlist of the user.
     * Sets the given music to the given rank.
     *
     * @param Request $request
     * @return \Response
     */
    public function udpateList(Request $request) {
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "author" => "required",
            "cover" => "required",
            "url" => "required",
            "rank" => "required|numeric"
        ]);

        if($validator->fails()) {
            return abort(400);
        } else {
            $playlist = $request->user()->playlist()->first();
            $playlist->musics()->where("rank", $request->rank)->delete();
            return Music::create([
                "title" => $request->title,
                "author" => $request->author,
                "cover" => $request->cover,
                "url" => $request->url,
                "rank" => $request->rank,
                "playlist_id" => $playlist->id
            ]);
        }
    }
}
