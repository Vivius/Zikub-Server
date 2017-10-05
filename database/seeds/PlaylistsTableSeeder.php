<?php

use Illuminate\Database\Seeder;

class PlaylistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Playlist::class)->create([
            "user_id" => 1
        ]);
    }
}
