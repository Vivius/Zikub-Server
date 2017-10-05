<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
        Schema::table('musics', function (Blueprint $table) {
            $table->foreign('playlist_id')
                ->references('id')->on('playlists')
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->dropForeign('playlists_user_id_foreign');
        });
        Schema::table('musics', function (Blueprint $table) {
            $table->dropForeign('musics_playlist_id_foreign');
        });
    }
}
