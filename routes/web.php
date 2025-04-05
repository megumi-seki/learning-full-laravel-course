<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view("welcome");

});

Route::view('/about', 'about')->name("about");

//route caching is recommended once you deploy your project on production 

/*Fallback Routes
Route::fallback(function(){
    return"Fallback";
});*/

/* group route
Route::prefix("admin")->group(function(){
    Route::get("/users", function (){});
});


Route::name("admin.")->group(function(){
    Route::get("/users", function (){
        return "/users";
    })->name("users");
    // the route name is gonna be admin.users!!
});*/

/* redirect by route
Route::get("/user/profile", function(){})->name("profile");

Route::get("/current-user", function(){
//    return redirect()->route("profile");

    return to_route("profile");
});*/

