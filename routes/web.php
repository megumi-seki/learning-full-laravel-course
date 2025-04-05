<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view("welcome");

});

Route::view("/about", "about")->name("about");

Route::apiResources([
    "cars" => CarController::class,
    "products" => ProductController::class,
]);


