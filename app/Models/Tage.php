<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vendor_type_id',
        'store_id'
    ];
}
