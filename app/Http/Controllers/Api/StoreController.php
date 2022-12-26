<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Tage;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Helper;
use File;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $validateUser = Validator::make($request->all(),
            [
                'vendor_type_id' => 'required',
                'name' => 'required',
                'image' => 'required',
                'description' => 'required',
                'address' => 'nullable',
                'zip_code' => 'nullable',
                'lat' => 'nullable',
                'log' => 'nullable',
                'location' => 'nullable',
                'delivery_prize' => 'required',
                'delivery_time' => 'required',
                'tage' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!empty($request->file('image'))){
                $image_data = Helper::fileUploadApi('upload/store',$request->file('image'));
            }


            $store = Store::create([
                'name' => $request->name,
                'vendor_type_id' => $request->vendor_type_id,
                'image' => $image_data['image_name'],
                'image_path' => $image_data['url'],
                'description' => $request->description,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'lat' => $request->lat,
                'log' => $request->log,
                'location' => $request->location,
                'delivery_prize' => $request->delivery_prize,
                'delivery_time' => $request->delivery_time,
            ]);

            if($store){

                foreach($request->tage as $t){
                    $tage = Tage::create([
                        'name' => $t,
                        'vendor_type_id' => $request->vendor_type_id,
                        'store_id' => $store->id,
                    ]);
                }


                return response()->json([
                    'status' => true,
                    'message' => 'Store Created Successfully',
                    'data' => $store,
                ], 200);
            }else{
                if (File::exists($image_data['url'])) {
                    File::delete($image_data['url']);
                }
                return response()->json([
                    'status' => false,
                    'message' => 'Store Not Created Successfully',
                ], 400);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }

    public function getStores(Request $request){
        try{
            $store = Store::where('vendor_type_id',$request->vendor_type_id)->get();

            if($store){
                foreach($store as $s){
                    $tage = Tage::where('store_id',$s->id)->get();

                    $s->tage = $tage;
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Store list By vendor type id',
                    'data' => $store,
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'store not exites'
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function storesDetails(Request $request){
        try{
            $store = Store::where('id',$request->store_id)->first();

            if($store){
                $tage = Tage::where('store_id',$store->id)->get();
                $store->tage = $tage;
                return response()->json([
                    'status' => true,
                    'message' => 'Store Details',
                    'data' => $store,
                ], 200);
            }else{
                return response()->json([
                    'status' => true,
                    'message' => 'Store not found',
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
