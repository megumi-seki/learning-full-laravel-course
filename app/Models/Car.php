<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;
    // whenever we delete information, the data will go to deleted_at column

    // set data which could be fillable with th 3 approach on HomeController
    protected $fillable = [
            "id",
            "maker_id",
            "model_id",
            "year",
            "price",
            "vin",
            "mileage",
            "car_type_id",
            "fuel_type_id",
            "user_id",
            "city_id",
            "address",
            "phone",
            "description",
            "published_at"
    ];

    // set data which cannot be filled (like black list) but $fillable is more common
    // protected $guarded = ["user_id"];
}
