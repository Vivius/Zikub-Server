<?php

namespace App\Http\Controllers;

use App\YoutubeApi;
use Illuminate\Http\Request;

class YoutubeApiController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    public function search($query) {
        $youtubeApi = new YoutubeApi();
        return $youtubeApi->search($query, 25);
    }
}
