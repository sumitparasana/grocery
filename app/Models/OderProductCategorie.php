<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OderProductCategorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'oder_id',
        'oder_product_id',
        'product_categories_id'
    ];
}
