<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProductCategorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'cart_product_id',
        'product_categories_id',
    ];
}
