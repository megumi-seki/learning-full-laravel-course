<?php

namespace App\Http\Controllers;

use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        // Select All Cars
        // $cars = Car::get();

        // Select published Cars
        // $cars = Car::where("published_at", "!=", null)->get();

        // Select the first published car
        // $car = Car::where("published_at", "!=", null)->first();

        // Select the first car
        // $car = Car::first();

        // Select the car with id 2
        // $car = Car::find(2);

        // sort cars by published at
        $cars = Car::orderBy("published_at", "desc")->get();

        // limit items 
        // $cars = Car::limit(2)->get();

        // we can combine every methods like below
        // $cars = Car::where("published_at", "!=", null)
        //     ->where("user_id", 1)
        //     ->orderBy("published_at", "desc")
        //     ->limit(2)
        //     ->get();

        // dump($cars);

        return view("home.index");
    }
}
