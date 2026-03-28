<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Idea;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Basiccaly I'm saying: if the user is the owner of the idea, then he can view it, otherwise he can't
        Gate::define('view-idea', function (User $user, Idea $idea) {
            return $user->id === $idea->user_id;
        });


    }
}
