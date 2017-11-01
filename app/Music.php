<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = "musics";
    protected $guarded = [];

    public function playlist()
    {
        return $this->belongsTo('App\Playlist');
    }
}
