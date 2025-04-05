<?php

use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view("welcome");

});

Route::view("/about", "about")->name("about");

/* group controller
Route::controller(CarController::class)->group(function(){
    Route::get("/car", "index");
    Route::get("/my-cars", "myCars");
});*/

/* single action controllers
Route::get("/car/invokable", CarController::class);
Route::get("/car", [CarController::class, "index"]);*/

