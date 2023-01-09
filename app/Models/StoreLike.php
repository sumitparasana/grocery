<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class StoreLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_type_id',
        'store_id',
        'is_like',
    ];

    static function getStoreLike($id){
        $store_like = StoreLike::where('store_id',$id)->where('is_like',1)->count();
        $total_user = User::count();
        $like = ($store_like / $total_user) * 100;

        return number_format($like, 0);
    }
}
