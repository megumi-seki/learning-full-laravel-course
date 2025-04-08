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
   
        // Maker::factory()
        // ->count(1)
        // ->hasModels(1, function(array $attributes, Maker $maker) {
        //     return [];
        // })
        // ->has(Model::factory()->count(3))
        // ->create();

        // $maker = Maker::factory()->create();
        // Model::factory()
        //     ->count(5)
        //     ->for($maker)
        //     // ->forMaker(["name" => "Lexus"])
        //     // ->for(Maker::factory()->state(["name" => "Lexus"]))
        //     //
        //     ->create();

        return view("home.index");
    }
}
