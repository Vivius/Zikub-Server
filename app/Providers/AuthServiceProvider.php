<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        // Music
        Gate::define('musics.delete', function($user, $music) {
            return $music->playlist()->first()->user_id == $user->id;
        });
        Gate::define('musics.post', function ($user, $playlist) {
            return $playlist->user_id == $user->id;
        });

        // Playlist
        Gate::define('playlists.put', function ($user, $playlist) {
            return $playlist->user_id == $user->id;
        });
    }
}
