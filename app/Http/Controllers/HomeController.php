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
        // $cars = Car::orderBy("published_at", "desc")->get();

        // limit items 
        // $cars = Car::limit(2)->get();

        // we can combine every methods like below
        // $cars = Car::where("published_at", "!=", null)
        //     ->where("user_id", 1)
        //     ->orderBy("published_at", "desc")
        //     ->limit(2)
        //     ->get();

        // dump($cars);

        // Insert data
        // $car = new Car();
        // $car->maker_id = 1;
        // $car->model_id = 1;
        // $car->year = 1900;
        // $car->price = 123;
        // $car->vin = 123;
        // $car->mileage = 123;
        // $car->car_type_id = 1;
        // $car->fuel_type_id = 2;
        // $car->user_id = 1;
        // $car->city_id = 1;
        // $car->address = "Lorem ipsum";
        // $car->phone = "123";
        // $car->description = null;
        // $car->published_at = now();
        // $car->save();

        // Insert data with associative array
        // $carData = [
        //     "maker_id" => 1,
        //     "model_id" => 1,
        //     "year" => 2024,
        //     "price" => 200000,
        //     "vin" => "999",
        //     "mileage" => 5000,
        //     "car_type_id" => 1,
        //     "fuel_type_id" => 2,
        //     "user_id" => 1,
        //     "city_id" => 1,
        //     "address" => "Something",
        //     "phone" => "999",
        //     "description" => null,
        //     "published_at" => now(),
        // ];

        // Approach 1
        // $car = Car::create($carData);

        // Approach 2
        // $car2 = new Car();
        // $car2->fill($carData);
        // $car2->save();

        // Approach 3
        // $car3 = new Car($carData);
        // $car3->save();

        // Update the data 
        // $car = Car::find(1);
        // $car->price = 1000;
        // $car->save();

        // Update or create new data if there's no matched data
        // $carData = [
        //         "maker_id" => 1,
        //         "model_id" => 1,
        //         "year" => 2024,
        //         "price" => 200000,
        //         "vin" => "9999",
        //         "mileage" => 5000,
        //         "car_type_id" => 1,
        //         "fuel_type_id" => 2,
        //         "user_id" => 1,
        //         "city_id" => 1,
        //         "address" => "Something",
        //         "phone" => "999",
        //         "description" => null,
        //         "published_at" => now(),
        //     ];
        // $car = Car::updateOrCreate(
        //     ["vin" => "9999", "price" => 200000],
        //     $carData);
        
        // dump($car);


        // update mass data
        // Car::where("published_at", null)
        //     ->where("user_id", 1)
        //     ->update(["published_at" => now()]);


        // delete single data
        // $car = Car::find(1);
        // $car->delete();

        // delete mass data
        // Car::destroy(2, 3);

        // Car:: where("published_at", null)
        //     ->where("user_id", 1)
        //     ->delete();

        // delete every data from the database without softdelete
        // Car::truncate();

        return view("home.index");
    }
}
