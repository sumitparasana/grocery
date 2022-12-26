<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'is_available',
        'product_id',
        'categorie_id',
        'store_id',
        'vendor_type_id',
        'deleted_at',
    ];
}
