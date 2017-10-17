<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YoutubeApi extends Model
{
    private static $DEVELOPPER_KEY = "AIzaSyCadPFjFbo2g_U-fAH9KrTaVKDcvT7TVdk";
    private $client;
    private $youtube;

    public function __construct(array $attributes = [])
    {
        parent::__construct();
        $this->client = new \Google_Client();
        $this->client->setDeveloperKey(self::$DEVELOPPER_KEY);
        $this->youtube = new \Google_Service_YouTube($this->client);
    }

    /**
     * Permet de faire une recherche sur Youtube en rapport avec le mot clé recherché.
     *
     * @param $keyword
     * @param $nbResults
     * @return array
     */
    public function search($keyword, $nbResults)
    {
        $searchResponse = $this->youtube->search->listSearch('id, snippet', array(
            'q' => $keyword,
            'maxResults' => $nbResults,
            'type' => "video"
        ));

        $musics = [];
        foreach ($searchResponse['items'] as $searchResult) {
            switch ($searchResult['id']['kind']) {
                case 'youtube#video':
                    $music = new Music();
                    $music->title = $searchResult['snippet']['title'];
                    $music->cover = $searchResult['snippet']['thumbnails']['medium']['url'];
                    $music->url = "https://www.youtube.com/watch?v=".$searchResult['id']['videoId'];
                    $music->author = $searchResult["snippet"]["channelTitle"];
                    array_push($musics, $music);
                    break;
            }
        }
        return $musics;
    }
}
