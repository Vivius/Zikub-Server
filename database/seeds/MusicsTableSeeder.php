<?php

use Illuminate\Database\Seeder;

class MusicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i <5; $i++) {
            factory(App\Music::class)->create([
                "playlist_id" => 1
            ]);
        }
    }
}
