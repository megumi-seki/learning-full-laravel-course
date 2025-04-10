<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        dd($request, request());
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Car $car)
    {
        // // If the request URL looks like this:
        // // http://127.0.0.1:8000/car/1?page=1
        // dump($request->path()); // Output: car/1
        // dump($request->url()); // Output: http://127.0.0.1:8000/car/1
        // dump($request->fullUrl()); // Output: http://127.0.0.1:8000/car/1?page=1
        // dump($request->method()); // Output: GET
        // if ($request->isMethod("post")) {
        //     // If the request method is POST
        // }
        // if ($request->isXmlHttpRequest()) {
        //     // If the request is an AJAX request
        // }
        // if ($request->is("admin/*")) {
        //     // If the request URL matches the pattern admin/*
        // }
        // if ($request->routeIs("admin.*")) {
        //     // If the route matches the pattern admin.*
        // }
        // if ($request->expectsJson()) {
        //     // If the request JSON response
        // }
        // dump($request->fullUrlWithQuery(["sort" => "price"])); 
        // // Output: http://127.0.0.1:8000/car/1?sort=price&page=1
        // dump($request->fullUrlWithoutQuery(["page"])); 
        // // Output: http://127.0.0.1:8000/car/1
        // dump($request->host()); //Output: 127.0.0.1
        // dump($request->httpHost()); //Output: 127.0.0.1:8000
        // dump($request->schemeAndHttpHost()); //Output: http://127.0.0.1
        // dump($request->header("Content-Type")); //Output: null
        // dump($request->bearerToken()); //Output: null
        // dump($request->ip()); //Output: 127.0.0.1

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
        
        $cars = $query->paginate(15);

        return view("car.search", ["cars" => $cars]);
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



/*// Where Clauses
$cars = Car::where("year", "=", 2020)
    ->where("price", ">", 10000)
    ->where("address", "like", "%york%")
    ->get(); // Or
$cars = Car::where([
    ["year", "=", 2020],
    ["price", ">", 10000],
    ["address", "like", "%york%"]
])->get();

// Or Where Clauses
// Select very old cars or very new ones
$cars = Car::where("year", "<", 1970)
    ->orWhere("year", ">", 2022)
    ->get();

// Car where mileage is not grater than 100000
$cars = Car::whereNot("mileage", ">", 100000)->get();

// Car where address or description containe "York"
$cars = Car::whereAny(["address", "description"], "like", "%York%")
    ->get();

//Cars where both address and description contains "York"
$cars = Car::whereAll(["address", "description"], "like", "%York%")
    ->get();

// whereBetween / orWhereBetween
// Select cars where year is between 2000 and 2020
$cars = Car::whereBetween("year", [2000, 2020])->get();

// whereNotBetween / orWhereNotBetween
// Select cars where year is not between 2000 and 2020
$cars = Car::whereNotBetween("year", [2000, 2020])->get();

// whereNull / whereNotNull / orWhereNull / orWhereNotNull
// Select cars which are not published yet
$cars = Car::whereNull("published_at")->get();
// Select cars which are published
$cars = Car::whereNotNull("published_at")->get();

// whereIn / whereNotIn / orWhereIn / orWhereNotIn
// Select cars where maker_id is 1 or 2
$cars = Car::whereIn("maker_id", [1, 2])->get();
// Select cars where maker_id is not 1 or 2
$cars = Car::whereNotIn("maker_id", [1, 2])->get();

// Select users which are signed up with Google
$users = User::whereNotNull("google_id");
// Select cars for users whic are signed up with Google
$users = User::whereIn("user_id", $users)->get();
// Generated SQL:
// select * from cars where user_id in (
//     select id 
//     from users
//     where google_id is not null
// )

// whereDate / whereMonth / whereDay / whereYear / whereTime
// published at specific date
->whereDate("published_at", "2024-07-12")
// published at specific month
->whereMonth("published_at", "07")
// published at the first day of the month
->whereDay("published_at", "01")
// published at last year
->whereYear("published_at", "2024")
// published at specific time
->whereTime("published_at", "=", "11:20:45")

// whereColumn / orWhereColumn
// Created and updated at the same time
->whereColumn("created_at", "=", "updated_at")
// Updated at is greated than created at
->whereColumn("updated_at", ">", "created_at")
->whereColumn([
    ["column1", "=", "column2"]
    ["updated_at", ">", "created_at"]
])

// whereBetweenColumns / whereNotBetweenColumns / orWhereBetweenColumns / orWhereNotBetweenColumns
$patients = DB::table("patients")
            ->whereBetweenColumns(
                "weight",
                ["minimum_allowed_weight", "maximum_allowed_weight"]
            )
            ->get();

$patients = DB::table()("patients")
            ->whereNotBetweenColumns(
                "weight",
                ["minimum_allowed_weight", "maximum_allowed_weight"]
            )
            ->get();

// Full Text Where Clauses (SQLite does not support this but the others do)
$cars = Car::wehreFullText("description", "bmw")
    ->get();*/







/*
// Multiple Where Grouping
Car::where("year", ">=", 2010)
    ->where("price", ">", 10000)
    ->orWhere("price", "<", 5000);
// Generated SQL:
// select * from "cars"
// where "year" >= 2010
// and "price" > 10000
// or "price" < 5000
// This would be considered as 
// (year >= 2010 AND price > 10000) OR price < 5000
// so Logical Grouping is important
Car::where("year", ">=", 2010)
    ->where(function (Builder $query) {
        $query->where("price", ">", 10000)
              ->orWhere("price", "<", 5000);
    });
// Generated SQL:
// select * from "cars"
// where "year" >= 2010
// and ("price" > 10000 or "price" < 5000)

// Where Exists Clause

// Select cars that have images
$carsWithImages = Car::whereExists(function ($query) {
    $query->select("id")
        ->from("car_images")
        ->whereColumn("car_images.car_id", "cars.id"); //laravel assum the parameter is equal
})->get();
// Or
$carsWithImages = Car::whereExisits(
    CarImage::select("id")
        ->whereColumn("car_images.car_id", "cars.id")
)->get();
// Generated SQL:
// select * from "cars"
// where exists (
//     select "id" from "car_images"
//     where "cars_images"."car_id" = "cars"."id"
// )





// Subquety Where Clause
// Find Sedan cars
$sedanCars = Car::where(function (Builder $query) {
    $query->select("name")
        ->from("car_types")
        ->whereColumn("cars.car_type_id", "car_types.id")
        ->limit(1);
}, "=", "Sedan")->get();
// The same as
$subquery = CarType::select("name")
    ->whereColumn("cars.car_type_id", "car_types.id")
    ->limit(1);
$sedanCars = Car::where($subquery, "=", "Sedan")->get();
// Generated SQL:
// SELECT *
// FROM "cars"
// WHERE (
//     SELECT "name"
//     FROM "car_types"
//     WHERE "cars"."car_type_id" = "car_types"."id"
//     LIMIT 1
// ) = "Sedan";

// another example of subquery where clauses
// Select cars which ha sprice bello acerage price
$cars = Car::where("price", "<", function(Builder $query){
    return $query->selectRaw("AVG(price)")->from("cars");
})->get();
// Generated SQL:
// SELECT * FROM "cars"
// WHERE "price" < (
//     SELECT AVG(price) FROM "cars"
// );





// Query Debugging
// Dump the query with paramenters
Car::where("price", ">", 10000)->dump();
// Dump and die
Car::where("price", ">", 10000)->dd();
// Dump the raw SQL, with parameters replaced already
Car::where("price", ">", value: 10000)->toSql();
// Dump raw SQL and die
Car::where("price", ">", 10000)->ddRawSql();*/