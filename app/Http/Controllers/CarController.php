<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;
// use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller /*  implements HasMiddleware */
{
    // public static function middleware(): array
    // {
    //     return [
    //         "auth",
    //         new Middleware("auth", except: ["show"], only: []),
    //         function(Request $request, Closure $next) {

    //         }
    //     ];
    // }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cars = $request->user()
            ->cars()
            ->with(["primaryImage", "maker", "carModel"])
            ->orderBy("created_at", "desc")
            ->paginate(15);
        return view("car.index", ["cars" => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("car.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        
        // Get validated data
        $data = $request->validated();
        // $data2 = $request->safe()->only(["maker_id", "car_model_id"]);
        // $data3 = $request->safe()->except(["published_at"]);
        // $data4 = $request->safe()->merge(["user_id" => Auth::id()]);

        // Get features data
        $featuresData = $data["features"] ?? [];
        // Get images
        $images = $request->file("images") ?: [];

        // Set user ID
        // $data["user_id"] = $request->user()->id();
        $data["user_id"] = Auth::id();
        // Create new car
        $car = Car::create($data);

        $car->features()->create($featuresData);

        foreach ($images as $i => $image) {
            $path = $image->store("images", "public");
            $car->images()->create(["image_path" => $path, "position" => $i + 1]);
        }       

        return redirect()->route("car.index")
            ->with("success", "Car was deleted");
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Car $car)
    {
        if(!$car->published_at) {
            abort(404);
        }
        return view("car.show", ["car" => $car]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        if ($car->user_id !== Auth::id()) {
            abort(403); // 403 = forbidden Impirtant for sequlity!!
        }
        return view("car.edit", ["car" => $car]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCarRequest $request, Car $car)
    {
        if ($car->user_id !== Auth::id()) {
            abort(403); // 403 = forbidden
        }
        $data = $request->validated();
        $features = array_merge([
            "air_conditioning" => 0,
            "power_windows" => 0,
            "power_door_locks" => 0,
            "abs" => 0,
            "cruise_control" => 0,
            "bluetooth_connectivity" => 0,
            "remote_start" => 0,
            "gps_navigation" => 0,
            "heated_seats" => 0,
            "climate_control" => 0,
            "rear_parking_sensors" => 0,
            "leather_seats" => 0,
        ], $data["features"] ?? []);
        $car->update($data);

        $car->features()->update($features);

        return redirect()->route("car.index")
            ->with("success", "Car was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        if ($car->user_id !== Auth::id()) {
            abort(403); // 403 = forbidden
        }
        $car->delete();

        return redirect()->route("car.index")
            ->with("success", "Car was deleted");
    }

    public function search(Request $request)
    {
        $maker = $request->integer("maker_id");
        $carModel = $request->integer("car_model_id");
        $carType = $request->integer("car_type_id");
        $fuelType = $request->integer("fuel_type_id");
        $state = $request->integer("state_id");
        $city = $request->integer("city_id");
        $yearFrom = $request->integer("year_from");
        $yearTo = $request->integer("year_to");
        $priceFrom = $request->integer("price_from");
        $priceTo = $request->integer("price_to");
        $mileage = $request->integer("mileage");
        $sort = $request->input("sort", "-published_at");

        $query = Car::where("published_at", "<", now())
            ->with(["primaryImage", "city", "maker", "carType", "fuelType", "carModel"]);

        if ($maker) {
            $query->where("maker_id", $maker);
        }
        if ($carModel) {
            $query->where("car_model_id", $carModel);
        }
        if ($state) {
            $query->join("cities", "cities.id", "=", "cars.city_id")
                ->where("cities.state_id", $state);
        }
        if ($city) {
            $query->where("city_id", $city);
        }
        if ($carType) {
            $query->where("car_type_id", $carType);
        }
        if ($fuelType) {
            $query->where("fuel_type_id", $fuelType);
        }
        if ($yearFrom) {
            $query->where("year", ">=", $yearFrom);
        }
        if ($yearTo) {
            $query->where("year", "<=", $yearTo);
        }
        if ($priceFrom) {
            $query->where("price", ">=", $priceFrom);
        }
        if ($priceTo) {
            $query->where("price", "<=", $priceTo);
        }
        if ($mileage) {
            $query->where("mileage", "<=", $mileage);
        }

        if (str_starts_with($sort, "-")) {
            $sort = subStr($sort, 1);
            $query->orderBy($sort, "desc");
        } else {
            $query->orderBy($sort);
        }
       
        $cars = $query->paginate(15)
                      ->withQueryString();

        return view("car.search", ["cars" => $cars]);
    }

    public function watchlist()
    {
        $cars = Auth::user()
            ->favoriteCars()
            ->with(relations: ["primaryImage", "city", "maker", "carType", "fuelType", "carModel"])
            ->paginate(15);
        return view("car.watchlist", ["cars" => $cars]);
    }

    public function carImages(Car $car)
    {
        return view("car.images", ["car" => $car]);
    }

    public function updateImages(Request $request, Car $car)
    {
        if ($car->user_id !== Auth::id()) {
            abort(403); // 403 = forbidden
        }

        $data = $request->validate([
            "delete_images" => "array",
            "delete_images.*" => "integer",
            "positions" => "array",
            "positions.*" => "integer",
        ]);

        $deleteImages = $data["delete_images"] ?? [];
        $positions = $data["positions"] ?? [];

        $imagesToDelete = $car->images()->whereIn("id", $deleteImages)->get();
        foreach ($imagesToDelete as $image) {
            if(Storage::disk("public")->exists($image->image_path))
            Storage::disk("public")->delete($image->image_path);
        }

        $car->images()->whereIn("id", $deleteImages)->delete();

        foreach ($positions as $id => $position) {
            $car->images()->where("id", $id)->update(["position" => $position]);
        }

        return redirect()->back()
            ->with("success", "Car images were updated");
    }

    public function addImages(Request $request, Car $car) 
    {
        if ($car->user_id !== Auth::id()) {
            abort(403); // 403 = forbidden
        }

        $images = $request->file("images") ?? [];

        $position = $car->images()->max("position") ?? 0;
        foreach ($images as $image) {
            $path = $image->store("images", "public");
            $car->images()->create([
                "image_path" => $path,
                "position" => $position + 1
            ]);
            $position++;
        }

        return redirect()->back()
            ->with("success", "New images were updated");
    }

}