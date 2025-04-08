<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    use HasFactory;
    // protected $table = "car_fuel_types";
    // protected $primatyKey = "fuel_type_id";
    // public $incrementing = false;
    // protected $keyType = "string";
    // public $timestamps = false;
    // const CREATED_AT = "create_date"; customize the column name
    // const UPDATE_AT = null; disable updated_at column
    public $timestamps = false;
}
