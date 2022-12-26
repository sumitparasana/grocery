<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'devices_id',
        'product_id',
        'store_id',
        'vendor_type_id',
        'product_count',
    ];
}
