<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Models\User;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = User::find(4)
            ->with(["primaryImage", "maker", "carModel"])
            ->cars()
            ->orderBy("created_at", "desc")
            ->get();
        return view("car.index", ["cars" => $cars]);
    }

    public function watchlist()
    {
        // TODO we come back to this
        $cars = User::find(4)
            ->favoriteCars
            ->with(["primaryImage", "city", "maker", "carType", "fuelType", "carModel"]);
        return view("car.watchlist", ["cars" => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("car.creat");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return view("car.show", ["car" => $car]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view("car.edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }

    public function search()
    {
        $query = Car::select("cars.*") // if you use join() method it's good practice to set select() like this
            ->where("published_at", "<", now())
            ->with(["primaryImage", "city", "maker", "carType", "fuelType", "carModel"])
            ->orderBy("published_at", "desc");
        
        // Join cars table and cities table together when cities.id = cars.city_id, and filer it by cities.state_id
        $query->join("cities", "cities.id", "=", "cars.city_id")
            ->join("car_types", "car_types.id", "=", "cars.car_type_id")
            ->where("cities.state_id", 1)
            ->where("car_types.name", "SUV");

        // Select all the cars values and name of cities table as city_name
        // $query->select("cars.*", "cities.name as city_name");

        $carCount = $query->count();
        $cars = $query->limit(value: 30)->get();

        dd($cars[0]);
        return view("car.search", ["cars" => $cars, "carCount" => $carCount]);
    }
}


/*
// Ordering Data
// Order by multiple columns
Car::orderBy("published_at", "desc")
    ->orderBy("price", "asc")
    ->get();

// Using predefined latest() and oldest() methods
Car::latest()->get(); //The same as
Car::orderBy("created_at", "desc")->get();

Car::oldest()->get(); //The same as
Car::orderBy("created_at", "asc")->get();

Car::latest("published_at")->get(); //The same as
Car::orderBy("published_at", "desc")->get();

// Select in random order
// Select cars in random order
$cars = Car::inRandomOrder()->get();

// Remove ordering
$query = Car::orderBy("published_at", "desc");
// Remove ordering or reorder
$cars = $query->reorder() // removes existing ordering
            ->orderBy("price") // applies new ordering
            ->get();

// Or you can also do
$cars = $query->reorder("price")->get();*/


// Advanced Join Clauses
// $query = Car::select("cars.*");
// $query->join("car_images", function(JoinClause $join) {
//             $join->on("cars.id", "=", "car_images.car_id")
//                     // ->orOn(/* Second Condition */)
//                     ->where("car_images.position", "=", 1);
//                     }); 