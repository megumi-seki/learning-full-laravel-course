<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\CarFeatures;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\User;



class HomeController extends Controller
{
    public function index()
    {
        // $car =Car::find(1);
        // dump($car->features, $car->primaryImage);

        // $car->features->abs = 0;
        // $car->features->save();

        // $car->features->update(["abs" => 0]);

        // $car->primaryImage->delete();

        // $car = Car::find(2);

        // $carFeatures = new CarFeatures([
        //     "abs" => false,
        //     "air_conditioning" => false,
        //     "power_windows" => false,
        //     "power_door_locks" => false,
        //     "cruise_control" => false,
        //     "bluetooth_connectivity" => false,
        //     "remote_start" => false,
        //     "gps" => false,
        //     "navigation" => false,
        //     "heated_seats" => false,
        //     "climate_control" => false,
        //     "rear_parking_sensors" => false,
        //     "lether_seats" => false
        // ]);
        
        // $car->features()->save($carFeatures);


        // One-to-many relationships
        // $car = Car::find(1);
        // dd($car->images);

        // Create new image
        // $image = new CarImage(["image_path" => "something", "position" => 2]);
        // $car->images()->save($image);

        // $car->images()->create(["image_path" => "something2", "position" => 3]);

        // $car->images()->saveMany([
        //     new CarImage(["image_path" => "something", "position" =>4]),
        //     new CarImage(["image_path" => "something", "position" =>5])
        // ]);

        // $car->images()->createMany([
        //     ["image_path" => "something", "position" =>6],
        //     ["image_path" => "something", "position" =>7]
        // ]);

        // Many-to-One Relations
        // $car = Car::find(1);
        // dd($car->CarType);

        // $carType = CarType::where("name", "Hatchback")->first();
        // dd($carType->cars);
        // The above does the same thing as the below
        // $cars = Car::whereBelongsTo($carType)->get();
        // dd($cars);

        // $car = Car::find(1);
        // $carType = CarType::where("name", "Sedan")->first();

        // // $car->car_type_id = $carType->id;
        // // $car->save();
        // The above does the same thing as the below
        // $car->carType()->associate($carType);
        // $car->save();


        // Many to many relationships
        // $car = Car::find(1);
        // dd($car->favouredUsers);

        // $user = User::find(1);
        // dd($user->favoriteCars);

        $user = User::find(1);
        // $user->favoriteCars()->attach([1, 2]);

        // delete all the existing ones and attach news
        // $user->favoriteCars()->sync([3]);

        $user->favoriteCars()->detach();

        return view("home.index");
    }
}
