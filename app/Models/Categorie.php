<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'store_id',
        'vendor_type_id',
        'in_oder',
        'deleted_at',
    ];
}
