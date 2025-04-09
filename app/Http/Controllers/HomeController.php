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
   
        $cars = Car::where("published_at", "<", now())
            // the importance of egar loading!!! to make your website work fast
            ->with(["primaryImage", "city", "maker", "carType", "fuelType", "carModel"])
            ->orderBy("published_at", "desc")
            ->limit(30)
            ->get();

        return view("home.index", ["cars" => $cars]);
    }
}
