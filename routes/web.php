<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $productUrl = route("product.view", ["lang" => "en", "id" => 1]);
    dd($productUrl);
    return view("welcome");

});

Route::view('/about-us', 'about')->name("about");

/*
// custom regex logic
Route::get('/username/{username}', function(string $username) {
   ;
})->where("username", "[a-z]+"); 
*/

Route::get('/p/{lang}/product/{id}', function(string $lang, string $id) {
    
})
->where(["lang" => "[a-z]{2}", "id" => "\d{4,}"])
->name("product.view");

/*
Route::get('/search/{search}', function(string $search) {
    return $search;
})->where("search", ".+");

//->whereNumber("id");  Only digits
//->whereAlpha("id");    Only uppercase and lowercase letters: 
//->whereAlphaNumeric("id");   Only alpha or number
//->whereIn("lang", ["en", "ka", "in"]);  only the three in array;
*/

