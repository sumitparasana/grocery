<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLike extends Model
{
    use HasFactory;

    protected $table = 'product_like';

    protected $fillable = [
        'user_id',
        'vendor_type_id',
        'store_id',
        'product_id',
        'is_like',
    ];

}
