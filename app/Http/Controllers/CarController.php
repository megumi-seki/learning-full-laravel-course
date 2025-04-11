<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request, request());
        $cars = User::find(1)
            ->cars()
            ->with(["primaryImage", "maker", "carModel"])
            ->orderBy("created_at", "desc")
            ->paginate(15);
            // ->withPath("/user/cars")
            // ->appends(["sort" => "price"])
            // ->withQueryString()
            // ->fragment("cars")
        return view("car.index", ["cars" => $cars]);
    }

    public function watchlist()
    {
        // TODO we come back to this
        $cars = User::find(4)
            ->favoriteCars()
            ->with(["primaryImage", "city", "maker", "carType", "fuelType", "carModel"])
            ->paginate(15);
        return view("car.watchlist", ["cars" => $cars]);
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
    public function store(Request $request)
    {

        // Get request data. We must not use all()!!
        $data = $request->validate( [
            "maker_id" => "required",
            "car_model_id" => "required",
            "year" => ["required", "integer", "min:1900", "max:" .date(format: "Y")],
            // "another_field" => Rule::requiredIf(fn() => true)
        ], [
            "required" => "Please fill :attribute field",
        ], [
            "maker_id" => "My Maker",
            "car_model_id" => "Model"
        ]);
        $validator = Validator::make($request->all(), [
            "maker_id" => "required",
            "car_model_id" => "required",
            "year" => ["required", "integer", "min:1900", "max:" .date(format: "Y")],
            // "another_field" => Rule::requiredIf(fn() => true)
        ], [
            "required" => "Please fill :attribute field",
        ], [
            "maker_id" => "My Maker",
            "car_model_id" => "Model"
        ]);

        // if ($validator->fails()) {
        //     //
        //     return redirect(route("car.create"))
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        // $data = $validator->validated();
        // $data = $validator->safe()->only(["maker_id", "model_id"]);
        // $data = $validator->safe()->except(["year"]);

        dd( $data);
        // Get features data
        $featuresData = $data["features"] ?? [];
        // Get images
        $images = /*(array)*/ $request->file("images") ?: [];

        // Set user ID
        $data["user_id"] = 1;
        // Create new Car
        $car = Car::create($data);

        $car->features()->create($featuresData);

        foreach ($images as $i => $image) {
            $path = $image->store("images", "public");
            $car->images()->create(["image_path" => $path, "position" => $i + 1]);
        }       

        return redirect()->route("car.index");
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
}
