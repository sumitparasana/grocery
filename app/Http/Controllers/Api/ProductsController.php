<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductCategorie;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Helper;
use File;

class ProductsController extends Controller
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
                'discount_price' => 'nullable',
                'price' => 'required',
                'capacity' => 'nullable',
                'available_qty' => 'nullable',
                'store_id' => 'required',
                'categorie_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!empty($request->file('image'))){
                $image_data = Helper::fileUploadApi('upload/products',$request->file('image'));
            }


            $store = Products::create([
                'name' => $request->name,
                'vendor_type_id' => $request->vendor_type_id,
                'image' => $image_data['image_name'],
                'image_path' => $image_data['url'],
                'description' => $request->description,
                'discount_price' => $request->discount_price,
                'price' => $request->price,
                'capacity' => $request->capacity,
                'available_qty' => $request->available_qty,
                'store_id' => $request->store_id,
                'categorie_id' => $request->categorie_id,
            ]);

            if(!$store){
                if (File::exists($image_data['url'])) {
                    File::delete($image_data['url']);
                }
                return response()->json([
                    'status' => false,
                    'message' => 'Store Not Created Successfully',
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Store Created Successfully',
                'data' => $store,
            ], 200);

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

    public function getProducts(Request $request){
        try{
            $products = Products::where('store_id',$request->store_id)->orderBy('sell_count','desc')->get();

            if(!$products){
                return response()->json([
                    'status' => true,
                    'message' => 'Store not found',
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Products list By store',
                'data' => $products,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getProductsByCategorie(Request $request){
        try{
            $products = DB::table('products as p')->join('categories as c','c.id','=','p.categorie_id')
            ->select('p.*','c.name as categorie_name')
            ->oderBy('sell_count','desc')
            ->get()->groupBy('categorie_name');

            if(!$products){
                return response()->json([
                    'status' => true,
                    'message' => 'Store not found',
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Store list By vendor type id',
                'data' => $products,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function productsDetails(Request $request){
        try{
            $products = Products::where('id',$request->product_id)->first();

            if($products){
                $productCategorie = ProductCategorie::where('product_id',$products->id)->get();

                $products->product_categorie = $productCategorie;
                return response()->json([
                    'status' => true,
                    'message' => 'Store Details',
                    'data' => $products,
                ], 200);
            }else{
                return response()->json([
                    'status' => true,
                    'message' => 'products not found',
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
