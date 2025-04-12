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
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
   
        // $user = $request->session()->get("user", "John");
        // $all = $request->session()->all();
        // dd($all);
        // $user2 = session("user", "John);

        // $request->session()->put("user", "Megumi");
        // session(["user" => "Megumi"]);

        $request->session()->forget("user");
        // $user = $request->session()->remove("user");

        $cars = Car::where("published_at", "<", now())
            // the importance of egar loading!!! to make your website work fast
            ->with(["primaryImage", "city", "maker", "carType", "fuelType", "carModel"])
            ->orderBy("published_at", "desc")
            ->limit(30)
            ->get();

        return view("home.index", ["cars" => $cars]);
    }
}
