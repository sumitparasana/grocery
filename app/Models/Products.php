<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'image_path',
        'price',
        'discount_price',
        'capacity',
        'available_qty',
        'deliverable',
        'vendor_type_id',
        'store_id',
        'categorie_id',
        'deleted_at',
    ];

}
