<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index()
    {
        $cars = Auth::user()
            ->favoriteCars()
            ->with(relations: ["primaryImage", "city", "maker", "carType", "fuelType", "carModel"])
            ->paginate(15);
            
        return view("watchlist.index", ["cars" => $cars]);
    }

    public function storeDestroy(Car $car)
    {
        $user = Auth::user();

        $carExists = $user->favoriteCars()->where("car_id", $car->id)->exists();

        if ($carExists) {
            $user->favoriteCars()->detach($car);

            return back()->with("success", "Car was removed from watchlist");
        }

        $user->favoriteCars()->attach($car);

        return back()->with("success","Car was added to watchlist");
    }
}
