<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            "name" => "Toto",
            "email" => "toto@gmail.com",
            "password" => bcrypt("test1234")
        ]);
        factory(App\User::class, 5)->create();
    }
}
