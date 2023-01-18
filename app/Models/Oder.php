<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'creation_date',
        'delivery_date',
        'payment_type',
        'delivery_address',
        'delivery_status',
        'store_id',
        'vendor_type_id',
        'amount',
        'payment_status',
        'paid_amount',
    ];
}
