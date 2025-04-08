<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\CarFeatures;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\User;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Sequence;



class HomeController extends Controller
{
    public function index()
    {
   
        // User::factory()
        //     ->has(Car::factory()->count(5), relationship: "favoriteCars") 
        //     // ->hasAttached(Car::factory()->count(5), ["col1" => "va", "favoriteCars"])
        //     ->create();

        return view("home.index");
    }
}
