<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        "vendor_type_id",
        "name",
        "image",
        "image_path",
        "description",
        "free_delivery",
        "address",
        "zip_code",
        "lat",
        "log",
        "location",
        "like",
        "delivery_prize",
        "delivery_time",
        "is_prime",
        "user_id",
    ];
}
