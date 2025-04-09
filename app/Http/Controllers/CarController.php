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
        $query = Car::where("published_at", "<", now())
            ->with(["primaryImage", "city", "maker", "carType", "fuelType", "carModel"])
            ->orderBy("published_at", "desc");
        $carCount = $query->count();
        $cars = $query->limit(30)->get();
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