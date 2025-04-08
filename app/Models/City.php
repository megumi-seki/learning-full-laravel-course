<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class City extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "state_id"
    ];
    
}
