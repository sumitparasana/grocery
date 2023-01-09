<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'oder_id',
        'product_id',
        'product_count',
        'product_price',
        'delivery_status',
    ];
}
