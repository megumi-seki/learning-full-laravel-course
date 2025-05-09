<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Once;
use Carbon\Carbon;

class Car extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
            "id",
            "maker_id",
            "car_model_id",
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

    public function carType(): BelongsTo
    {
        return $this->belongsTo(CarType::class);
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType:: class);
    }

    public function maker(): BelongsTo
    {
        return $this->belongsTo(Maker:: class);
    }

    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel:: class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User:: class, "user_id");
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City:: class);
    }

    public function features(): HasOne
    {
        return $this->hasOne(CarFeatures::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(CarImage::class)
            ->oldestOfMany("position");
    }

    public function images(): HasMany
    {
        return $this->hasMany(CarImage::class)->orderBy("position");
    }

    public function favouredUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "favorite_cars");
    }    

    public function getCreateDate(): String 
    {
        return (new Carbon($this->created_at))->format("Y-m-d");
    }

    public function getTitle()
    {
        return $this->year . " - " . $this->maker->name . " " . $this->carModel->name;
    }

    public function isInWatchlist(User $user = null)
    {
        return $this->favouredUsers->contains($user);
    }
}
