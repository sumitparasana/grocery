<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Oder;
use App\Models\OderProduct;
use App\Models\OderProductCategorie;
use App\Models\CartProduct;
use App\Models\CartProductCategorie;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Helper;
use File;

class OderController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'vendor_type_id' => 'required',
                'store_id' => 'required',
                'amount' => 'required',
                'payment_type' => 'required',
                'address' => 'required',
                'cart_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $oder = new Oder;
            $oder->user_id = auth()->user()->id;
            $oder->status = 1;
            $oder->creation_date = date('Y-m-d');
            $oder->payment_type = $request->payment_type;
            $oder->delivery_address = $request->address;
            $oder->delivery_status = 0;
            $oder->store_id = $request->store_id;
            $oder->vendor_type_id = $request->vendor_type_id;
            $oder->amount = $request->amount;

            $data = [];
            if($oder->save()){
                $data['oder'] = $oder;

                $product = DB::table('cart_products as cp')
                ->join('products as p','p.id','=','cp.product_id')
                ->selectRaw('cp.*,p.price')
                ->where('cp.cart_id',$request->cart_id)
                ->where('cp.store_id',$oder->store_id)
                ->where('cp.vendor_type_id',$oder->vendor_type_id)
                ->get();

                if($product){
                    foreach($product as $p){
                        $oder_product = new OderProduct([
                            'oder_id' => $oder->id,
                            'product_id' => $p->product_id,
                            'product_count' => $p->product_count,
                            'product_price' => $p->price
                        ]);

                        if($oder_product->save()){
                            $data['oder_product'][] = $oder_product;

                            if($request->vendor_type_id == 1){
                                $product_categorie = DB::table('cart_product_categories as $cpc')
                                ->where('cart_product_id',$p->id)->get();
                                if($product_categorie){
                                    foreach($product_categorie as $pc){
                                        $oder_product_categorie = new OderProductCategorie([
                                            'oder_id' => $oder->id,
                                            'oder_product_id' => $oder_product->id,
                                            'product_categories_id' => $pc->product_categories_id
                                        ]);

                                        if($oder_product_categorie->save()){
                                            $data['oder_product']['oder_product_categorie'][] = $oder_product_categorie;
                                            CartProductCategorie::where('id',$pc->id)->delete();
                                        }
                                    }
                                    if(CartProductCategorie::where('cart_product_id',$p->id)->count() == 0){
                                        CartProduct::where('id',$p->id)->where('cart_id',$request->cart_id)->delete();
                                    }
                                }
                            }else{
                                CartProduct::where('id',$p->id)->where('cart_id',$request->cart_id)->delete();
                            }
                        }
                    }
                }else{
                    $oder = Oder::where('id',$oder->id)->delete();
                    return response()->json([
                        'status' => false,
                        'message' => 'cart product not found'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'oder not create'
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'oder details',
                'data' => $data,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
