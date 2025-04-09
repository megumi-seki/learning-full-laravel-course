<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarFeatures;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\State;
use App\Models\Maker;
use App\Models\User;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create car types with the following data using factories
        CarType::factory()
            ->sequence(
                ["name" => "Sedan"],
                ["name" => "Hatchback"],
                ["name" => "SUV"],
                ["name" => "Pickup Track"],
                ["name" => "Minivan"],
                ["name" => "Coupe"],
                ["name" => "Crossover"],
                ["name" => "Sports Car"]
            )
            ->count(8)
            ->create();

        // Create fuel Types
        FuelType::factory()
            ->sequence(
                ["name" => "Gasoline"], 
                ["name" => "Diesel"], 
                ["name" => "Electric"], 
                ["name" => "Hybrid"]
                )
            ->count(4)
            ->create();

        // Create States with cities
        $states = [
            "California" => ["Los Angeles", "San Diego", "San Jose", "San Francisco", "Fresno", "Sacramento", "Long Beach", "Oakland", "Bakersfield", "Anaheim"],
            "Texas" => ["Houston", "San Antonio", "Dallas", "Austin", "Fort Worth", "El Paso", "Arlington", "Corpus Christi", "Plano", "Laredo"],
            "Florida" => ["Jacksonville", "Miami", "Tampa", "Orlando", "St. Petersburg", "Hialeah", "Port St. Lucie", "Tallahassee", "Cape Coral", "Fort Lauderdale"],
            "New York" => ["New York City", "Buffalo", "Rochester", "Yonkers", "Syracuse", "Albany", "New Rochelle", "Mount Vernon", "Schenectady", "Utica"],
            "Illinois" => ["Chicago", "Aurora", "Joliet", "Naperville", "Rockford", "Springfield", "Elgin", "Peoria", "Champaign", "Waukegan"],
            "Pennsylvenia" => ["Philadelphia", "Pittsburgh", "Allentown", "Erie", "Reading", "Scranton", "Bethlehem", "Lancaster", "Harrisburg", "York"],
            "Georgia" => ["Atlanta", "Augusta", "Columbus", "Macon", "Savannah", "Athens", "Sandy Springs", "Roswell", "Johns Creek", "Albany"],
            "Ohio" => ["Columbus", "Cleveland", "Cincinnati", "Toledo", "Akron", "Dayton", "Parma", "Canton", "Youngstown", "Lorain"],
            "North Calorina" => ["Charlotte", "Raleigh", "Greensboro", "Durham", "Winston-Salem", "Fayetteville", "Cary", "Wilmington", "High Point", "Concord"],
            "Michigan" => ["Detroit", "Grand Rapids", "Warren", "Sterling Heights", "Ann Arbor", "Lansing", "Flint", "Dearborn", "Livonia", "Westland"],
        ];

            foreach($states as $state => $cities) {
                State::factory()
                    ->state(["name" => $state])
                    ->has(
                        City::factory()
                        ->count(count($cities))
                        ->sequence(...array_map(fn($city) => ["name" =>$city], $cities))
                    )
                    ->create();
            }

        // Create makers with their corresponding models
        $makers = [
            "Toyota" => ["Camry", "Corolla", "Prius", "RAV4", "Highlander", "Tacoma", "4Runner", "Sienna", "Avalon", "Yaris"],
            "Ford" => ["F-150", "Escape", "Explorer", "Fusion", "Mustang", "Edge", "Ranger", "Expedition", "Bronco", "Maverick"],
            "Honda" => ["Civic", "Accord", "CR-V", "Pilot", "Fit", "Odyssey", "HR-V", "Ridgeline", "Insight", "Passport"],
            "Chevrolet" => ["Silverado", "Equinox", "Malibu", "Traverse", "Camaro", "Tahoe", "Trailblazer", "Colorado", "Impala", "Suburban"],
            "Nissan" => ["Altima", "Sentra", "Rogue", "Versa", "Murano", "Pathfinder", "Maxima", "Frontier", "Armada", "Kicks"],
            "Lexus" => ["ES", "IS", "RX", "NX", "GX", "LS", "UX", "LC", "LX", "RC"]
        ];

        foreach($makers as $maker => $models) {
            Maker::factory()
            ->state(["name" => $maker])
            ->has(
                CarModel::factory()
                    ->count(count($models))
                   ->sequence(...array_map(fn($model) => ["name" => $model], $models))
                )
            ->create();
        }

        // Create users, cars with images and features
        // Create 3 users first, then create 2 more users,
        // and for each user (from the last 2 users) create 50 cars,
        // wih images and features and add these cars to favorite cars
        // off these 2 users.

        User::factory()
            ->count(3)
            ->create();
        
        User::factory()
            ->count(2)
            ->has(
                Car::factory()
                ->count(50)
                ->has(
                    CarImage::factory()
                    ->count(5)
                    ->sequence(fn (Sequence $sequence) => 
                    ["position" => $sequence->index % 5 + 1]),
                    "images"
                    )
                    // ->sequence(
                    //     ["position" => 1],
                    //     ["position" => 2],
                    //     ["position" => 3],
                    //     ["position" => 4],
                    //     ["position" => 5]
                    //     , "images")
                ->hasFeatures(),
                "favoriteCars"
                )
            ->create();
    }
}



/*// Query Data - Different Methods

// Query Data without model
$cars = DB::table("cars")->get();
dd($cars);

// Query Data with model
$query = Car::query();
// Use any methods fro query class: where, orderBy, limit, etc...
// Select all records
$car = Car::get();
// Select a single record
$car = Car::first();

// Select a single value
// Get a single value from the first car
$highestPrice = Car::orderBy("price", "desc")->valuue("price");

// Select list of values of a single column
// Select list of prices sorted by pricein descending order
$prices = Car::orderBy("price", "desc")->pluck("price");
// Select list of prices and return associative array with car id as key
$prices = Car::orderBy("price", "desc")->pluck("price", "id");

// Check if a specific user has/does not have cars
if (Car::where("user_id", 1)->exists()) {
    // User has cars
}
if (Car::wheer("user_id", 1)->doesntExist()) {
    // User does not have cars
}

// Specify select
// Select only vin code and price of the cars
$cars = Car::select("vin", "price as car_price")->get();
// You can also add another columns in select at later stage
$query = Car::select("vin", "price as car_price");
// Each car will have 3 columns selected: vin, price with name car_price and mileage
$cars = $query->addSelect("mileage")->get();

// Select Distinct records
// Select distinct maker and models from the cars
$distinct = Car::select ("maker_id", "model_id")
                ->distinct()
                ->get();

// Limit and Offset
// Using limit and offset. Select 10 cars starting from 6th
$cars = Car::limit(10)->offset(5)->get();
// The same as above. Using skip and take. Skip 5 cars and take 10
$cars = Car::skip(5)->take(10)->get();

// Select record count
$carCount = Car::where("published_at", "!=", null)
                ->count();

// Select minimun, maximun and average price
// Select minimun, maximun and average price of the cars
$minPrice = Car::where("published_at", "!=", null)
                ->min("price");
$maxPrice = Car::where("published_at", "!=", null)
                ->max("price");
$avgPrice = Car::where("published_at", "!=", null)
                ->avg("price");

// Select car IDs with how many images each car has
$cars = CarImage::selectRaw("car_id, count(*) as image_count")
    ->groupBy("car_id")
    ->get();
dd($cars[0]);*/