<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = "playlists";
    protected $guarded = [];

    public function musics() {
        return $this->hasMany('App\Music');
    }
}
