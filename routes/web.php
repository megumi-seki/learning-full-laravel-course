<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $person = [
        "name" => "Zura",
        "email" => "zura@example.com",
    ];
    dd($person);
    return view('welcome');
});

Route::view('/about', 'about');

Route::get('/product/{id}', function(string $id) {
    return "Works! $id";
})->whereNumber("id"); //  Only digits

//->whereAlpha("id");    Only uppercase and lowercase letters: 
//->whereAlphaNumeric("id");   Only alpha or number
//->whereIn("lang", ["en", "ka", "in"]);  only the three in array;