<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

use function Termwind\parse;

class CarTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_should_not_be_able_to_acccess_to_car_create_page_as_guest_user(): void
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->get(route("car.create"));

        // $response->ddSession();
        // $response->ddHeaders();
        // $response->dd();

        // $response->dump();
        // $response->dumpHeaders();
        // $response->dumpSession();

        $response->assertRedirectToRoute(("login"));
        $response->assertStatus(302);
    }

    public function test_should_be_able_to_acccess_car_create_page_as_authenticated_user(): void
    {
        /**
         * @var TestResponse $response
         */

        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route("car.create"));

        $response->assertOk()
            ->assertSee("Add new car");
    }

    public function test_should_not_be_able_to_acccess_to_my_car_page_as_guest_user(): void
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->get(route("car.index"));
        
        $response->assertRedirectToRoute("login");
        // $response->assertStatus(302);
    }

    public function test_should_be_able_to_acccess_my_car_page_as_authenticated_user(): void
    {
        /**
         * @var TestResponse $response
         */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route("car.index"));

        $response->assertOk()
            ->assertSee("My Cars");
    }

    public function test_should_not_create_car_with_empty_data()
    {
        /** @var TestResponse $response */
        $user = User::factory()->create();
        $this->seed();
        $response = $this->actingAs($user)
            ->post(route("car.store"), [
            "maker_id" => null,
            "car_model_id" => null,
            "year" => null,
            "price" => null,
            "vin" => null,
            "mileage" => null,
            "car_type_id" => null,
            "fuel_type_id" => null,
            "state_id" => null,
            "city_id" => null,
            "address" => null,
            "phone" => null,
            "description" => null,
            "published_at" => null
        ]);

        $response->assertInvalid(([
            "maker_id",
            "car_model_id",
            "year",
            "price",
            "vin",
            "mileage",
            "car_type_id",
            "fuel_type_id",
            "state_id",
            "city_id",
            "address",
            "phone",
        ]));
    }

    public function test_should_not_create_car_with_invalid_data()
    {
        /** @var TestResponse $response */
        $user = User::factory()->create();
        $this->seed();
        $response = $this->actingAs($user)
            ->post(route("car.store"), [
            "maker_id" => 100,
            "car_model_id" => 100,
            "year" => 1800,
            "price" => -100,
            "vin" => "123",
            "mileage" => -1000,
            "car_type_id" => 100,
            "fuel_type_id" => 100,
            "state_id" => 100,
            "city_id" => 1000,
            "address" => "123",
            "phone" => "123",
        ]);

        $response->assertInvalid(([
            "maker_id",
            "car_model_id",
            "year",
            "price",
            "vin",
            "mileage",
            "car_type_id",
            "fuel_type_id",
            "state_id",
            "city_id",
            "phone",
        ]));
    }

    public function test_should_create_car_with_valid_data()
    {
        /** @var TestResponse $response */
        $this->seed();
        $countCars = Car::count();
        $countImages = CarImage::count();
        $user = User::factory()->create();
        
        $images = [
            UploadedFile::fake()->image("1.jpg"),
            UploadedFile::fake()->image("2.jpg"),
            UploadedFile::fake()->image("3.jpg"),
            UploadedFile::fake()->image("4.jpg"),
            UploadedFile::fake()->image("5.jpg"),
        ];

        $features = [
            "abs" => "1",
            "air_conditioning" => "1",
            "power_windows" => "1",
        ];

        $carData = [
            "maker_id" => 1,
            "car_model_id" => 1,
            "year" => 2020,
            "price" => 100,
            "vin" => "12345678910123456",
            "mileage" => 1000,
            "car_type_id" => 1,
            "fuel_type_id" => 1,
            "state_id" => 1,
            "city_id" => 1,
            "address" => "123",
            "phone" => "123456789",
            "features" => $features,
            "images" => $images,
        ];

        $response = $this->actingAs($user)
            ->post(route("car.store"), $carData);

        $response->assertRedirectToRoute("car.index")
            ->assertSessionHas("success");

        $lastCar = Car::latest("id")->first();
        $features["car_id"] = $lastCar->id;

        $carData["id"] = $lastCar->id;
        unset($carData["features"]);
        unset($carData["images"]);
        unset($carData["state_id"]);
        
        $this->assertDatabaseCount("cars", $countCars + 1);
        $this->assertDatabaseCount("car_images", $countImages + count($images));
        $this->assertDatabaseCount("car_features", $countCars + 1);
        $this->assertDatabaseHas("car_features", $features);
        $this->assertDatabaseHas("cars", $carData);
    }

    public function test_should_desplay_update_car_page_with_correct_data()
    {
        $this->seed();
        $user = User::first();
        $firstCar = $user->cars()->first();

        /** @var TestResponse $response */
        $response = $this->actingAs($user)->get(route("car.edit", $firstCar));

        $response->assertSee("Edit Car:");
        $response->assertSeeInOrder([
            '<select id="makerSelect" name="maker_id">',
            '<option value="'.$firstCar->maker_id.'"',
            'selected>',
            $firstCar->maker->name,
            '</option>',
        ], false);
        $response->assertSeeInOrder([
            '<select id="modelSelect" name="car_model_id">',
            '<option value="'.$firstCar->car_model_id.'"',
            'selected >',
            $firstCar->car_model_id
        ], false);
        $response->assertSeeInOrder([
            '<input type="radio" name="car_type_id" value="'.$firstCar->car_type_id.'"',
            'checked />',
            $firstCar->carType->name
        ], false);
        $response->assertSeeInOrder([
            '<input type="number" placeholder="Price" name="price" value="'.$firstCar->price.'"/>'
        ], false);
        $response->assertSeeInOrder([
            '<input placeholder="Vin Code" name="vin" value="'.$firstCar->vin.'"/>'
        ], false);
        $response->assertSeeInOrder([
            '<input placeholder="Mileage" name="mileage" value="'.$firstCar->mileage.'" />'
        ], false);
        $response->assertSeeInOrder([
            '<input type="radio" name="fuel_type_id" value="'.$firstCar->fuel_type_id.'"',
            'checked/>',
            $firstCar->fuelType->name
        ], false);
        $response->assertSeeInOrder([
            '<select id="stateSelect" name="state_id">',
            '<option value="'.$firstCar->city->state_id.'" selected>'.$firstCar->city->state->name.'</option>'
        ], false);
        $response->assertSeeInOrder([
            '<select id="citySelect" name="city_id">',
            '<option value="'.$firstCar->city_id.'" data-parent="'.$firstCar->city->state_id.'" selected>'.$firstCar->city->name.'</option>'       
        ], false);
        $response->assertSeeInOrder([
            '<input placeholder="Address" name="address" value="'.$firstCar->address.'"/>'
        ], false);
        $response->assertSeeInOrder([
            '<input placeholder="Phone" name="phone" value="'.$firstCar->phone.'" />'
        ], false);
        $response->assertSeeInOrder([
            '<textarea rows="10" name="description">'.$firstCar->description.'</textarea>'
        ], false);   
        $response->assertSeeInOrder([
            '<input type="date" name="published_at"',
            'value="'.Carbon::parse($firstCar->published_at)->format('Y-m-d').'">'
        ], false);
    }

    public function test_should_successfully_update_the_car_detailes()
    {
        /** @var TestResponse $response */
        $this->seed();
        $countCars = Car::count();
        $user = User::first();
        $firstCar = $user->cars()->first();

        $features = [
            "abs" => "1",
            "air_conditioning" => "1",
            "power_windows" => "1",
        ];

        $carData = [
            "maker_id" => 1,
            "car_model_id" => 1,
            "year" => 2020,
            "price" => 100,
            "vin" => "12345678910123456",
            "mileage" => 1000,
            "car_type_id" => 1,
            "fuel_type_id" => 1,
            "state_id" => 1,
            "city_id" => 1,
            "address" => "123",
            "phone" => "123456789",
            "features" => $features
        ];

        $response = $this->actingAs($user)
            ->put(route("car.update", $firstCar), $carData);
 
        $response->assertRedirectToRoute("car.index")
            ->assertSessionHas("success");
 
        $carData["id"] = $firstCar->id;
        $features["car_id"] = $firstCar->id;
        unset($carData["state_id"]);
        unset($carData["features"]);
        unset($carData["images"]);
         
        $this->assertDatabaseCount("cars", $countCars);
        $this->assertDatabaseHas("cars", $carData);
        $this->assertDatabaseCount("car_features", $countCars);
        $this->assertDatabaseHas("car_features", $features);
    }

    public function test_should_successfully_delete_a_car()
    {
        /** @var TestResponse $response */
        $this->seed();
        $user = User::first();
        $firstCar = $user->cars()->first();

        $response = $this->actingAs($user)
            ->delete(route("car.destroy", $firstCar));
        
        $response->assertRedirectToRoute("car.index")
            ->assertSessionHas("success");

        $this->assertDatabaseHas("cars", [
            "id" => $firstCar->id,
            "deleted_at" => now()
        ]);
    }

    public function test_should_successfully_add_images_to_car()
    {
        /** @var TestResponse $response */
        $this->seed();
        $user = User::first();
        $firstCar = $user->cars()->first();
        // $imageCount = CarImage::count();
        $oldCount = $firstCar->images()->count();

        $images = [
                UploadedFile::fake()->image("1.jpg"),
                UploadedFile::fake()->image("2.jpg"),
                UploadedFile::fake()->image("3.jpg"),
                UploadedFile::fake()->image("4.jpg"),
                UploadedFile::fake()->image("5.jpg"),
        ];

        $response = $this->actingAs($user)
            ->post(route("car.addImages", $firstCar), ["images" => $images]);

        $response->assertRedirectToRoute("car.images", $firstCar)
            ->assertSessionHas("success");
        
        $newCount = $firstCar->images()->count();
        $this->assertEquals($newCount, $oldCount + count($images));

    }

    public function test_should_successfully_delete_images_on_the_car()
    {
        /** @var TestResponse $response */
        $this->seed();
        $user = User::first();
        $firstCar = $user->cars()->first();
        $oldCount = $firstCar->images()->count();
        $ids = $firstCar->images()->limit(2)->pluck("id")->toArray();

        $response = $this->actingAs($user)
            ->put(route("car.updateImages", $firstCar), 
                ["delete_images" => $ids]);
        
        $response->assertRedirectToRoute("car.images", $firstCar)
            ->assertSessionHas(["success"]);

        $newCount = $firstCar->images()->count();
        $this->assertEquals($newCount, $oldCount - 2);
    }

    public function test_should_successfully_update_image_positions_on_the_car()
    {
        /** @var TestResponse $response */
        $this->seed();
        $user = User::first();
        $firstCar = $user->cars()->first();
        $images = $firstCar->images()->reorder("position" , "desc")->get();

        $data = [];
        foreach($images as $i => $imageInfo) {
            $data[$imageInfo->id] = $i +1;
        } 
    
        $response = $this->actingAs($user)
            ->put(route("car.updateImages", $firstCar), ["positions" => $data]);

        $response->assertRedirectToRoute("car.images", $firstCar)
            ->assertSessionHas(["success"]);
        
            foreach ($data as $id => $position) {
                $this->assertDatabaseHas("car_images", [
                    "id" => $id, "position" => $position
                ]);
            }
       
    }
        
        


}
