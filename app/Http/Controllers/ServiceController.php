<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Store;
use App\Models\Categorie;
use App\Models\Products;


class ServiceController extends Controller
{
    public function getUserByVendor(Request $request,$id){
        $user = User::where('role',$id)->select('id','name')->get();

        return $user;
    }

    public function getStoreByVendor(Request $request,$id){
        $store = Store::where('vendor_type_id',$id)->select('id','name')->get();

        return $store;
    }

    public function getCategorieByStore(Request $request,$id){
        $categorie = Categorie::where('store_id',$id)->select('id','name')->get();

        return $categorie;
    }

    public function getProductByStore(Request $request,$id){
        $product = Products::where('store_id',$id)->select('id','name')->get();

        return $product;
    }
}
