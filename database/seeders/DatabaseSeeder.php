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
