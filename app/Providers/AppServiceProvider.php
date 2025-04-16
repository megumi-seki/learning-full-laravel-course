<?php

namespace App\Providers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::defaultView("pagination");
        View::share("year", date("Y"));



        // Gate::before(function (User $user, string $ability) {
        //     if ($user->isAdmin()) {
        //         return true;
        //     }

        //     if ($user->isGuest()) {
        //         return false;
        //     }
        // });

        // Gate::after(function (User $user, string $ability) {
        //     // Decide to give permission or not
        // });

        // Gate::define("update-car", function(User $user, Car $car) {
        //     return $user->id === $car->user_id ? Response::allow() 
        //         : Response::denyWithStatus(404);
        // });

        // Gate::define("delete-car", function(User $user, Car $car) {
        //     return $user->id === $car->user_id ? Response::allow() 
        //         : Response::denyWithStatus(404);
        // });
    }
}
