<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreLike;
use App\Models\ProductLike;
use App\Models\Store;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Helper;
use File;

class StoreLikeController extends Controller
{
    public function addLike(Request $request){
        try {

            $store_like = StoreLike::where('user_id',auth()->user()->id)->where('store_id',$request->store_id)->first();

            if($store_like){
                if($store_like->is_like){
                    $store_like->is_like = false;
                }else{
                    $store_like->is_like = true;
                }

                if($store_like->save()){
                    return response()->json([
                        'status' => true,
                        'message' => 'store like change Successfully',
                        'data' => $store_like
                    ], 200);
                }
            }else{
                $like = new StoreLike([
                    'user_id' => auth()->user()->id,
                    'vendor_type_id' => $request->vendor_type_id,
                    'store_id' => $request->store_id,
                    'is_like' => true
                ]);

                if($like->save()){
                    return response()->json([
                        'status' => true,
                        'message' => 'store like add Successfully',
                        'data' => $like
                    ], 200);
                }
            }

            return response()->json([
                'status' => false,
                'message' => 'try agin'
            ], 400);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function homeLikeStore(Request $request){
        try {
            $store = DB::table('stores as s')
                ->join('store_likes as sl','sl.store_id','=','s.id')
                ->where('sl.is_like',1)
                ->where('sl.user_id',auth()->user()->id)
                ->where('sl.vendor_type_id',3)
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'user like store',
                'data' => $store
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function homeRatingStore(Request $request){
        try {
            $store = Store::where('vendor_type_id',3)->get();

            if($store){
                foreach($store as $s){
                    $like = StoreLike::getStoreLike($s->id);
                    $s->store_like = $like;
                }

                $store = $store->sortBy('store_like');
                return response()->json([
                    'status' => true,
                    'message' => 'home page store by reating',
                    'data' => array_values($store->toArray())
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function addLikeProduct(Request $request){
        try {

            $product_like = ProductLike::where('user_id',auth()->user()->id)
            ->where('store_id',$request->store_id)
            ->where('product_id',$request->product_id)->first();

            if($product_like){
                if($product_like->is_like){
                    $product_like->is_like = false;
                }else{
                    $product_like->is_like = true;
                }

                if($product_like->save()){
                    return response()->json([
                        'status' => true,
                        'message' => 'product like change Successfully',
                        'data' => $product_like
                    ], 200);
                }
            }else{
                $like = new ProductLike([
                    'user_id' => auth()->user()->id,
                    'vendor_type_id' => $request->vendor_type_id,
                    'store_id' => $request->store_id,
                    'product_id' => $request->product_id,
                    'is_like' => true
                ]);

                if($like->save()){
                    return response()->json([
                        'status' => true,
                        'message' => 'product like add Successfully',
                        'data' => $like
                    ], 200);
                }
            }

            return response()->json([
                'status' => false,
                'message' => 'try agin'
            ], 400);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getLikeProduct(){
        try {
            $product = DB::table('product_like as pl')
                ->leftJoin('products as p','p.id','=','pl.product_id')
                ->leftJoin('categories as c','c.id','=','p.categorie_id')
                ->leftJoin('stores as s','s.id','=','p.store_id')
                ->selectRaw('pl.*,p.name as product_name,p.price as product_price,c.name as categorie_name,s.name as store_id')
                ->where('pl.user_id',auth()->user()->id)
                ->get()->groupBy('categorie_name');

            return response()->json([
                'status' => true,
                'message' => 'product like add Successfully',
                'data' => $like
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
