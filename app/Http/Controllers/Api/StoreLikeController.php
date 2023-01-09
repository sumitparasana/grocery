<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreLike;
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

                // return $store;
                return $store->sortBy('store_like');
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
