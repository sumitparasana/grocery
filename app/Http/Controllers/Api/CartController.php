<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductCategorie;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Helper;
use File;

class CartController extends Controller
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
        try{
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'vendor_type_id' => 'required',
                'product_id' => 'required',
                'store_id' => 'required',
                'devices_id' => 'required',
                'product_count' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $cart = Cart::where('user_id',$request->user_id)->where('devices_id',$request->devices_id)->first();

            if($cart){
                $cart_product = new CartProduct([
                    'cart_id' => $cart->id,
                    'product_id' => $request->product_id,
                    'store_id' => $request->store_id,
                    'vendor_type_id' => $request->vendor_type_id,
                    'product_count' => $request->product_count,
                ]);

                if($cart_product->save()){
                    if(isset($request->product_categorie_id)){
                        foreach($request->product_categorie_id as $pci){
                            $cart_product_categorie = new CartProductCategorie([
                                'cart_id' => $cart_product->cart_id,
                                'cart_product_id' => $cart_product->id,
                                'product_categories_id' => $pci
                            ]);
                            $cart_product_categorie->save();
                        }
                    }
                }

                $cart->cart_product = $cart_product;
                if($cart_product->save()){
                    return response()->json([
                        'status' => true,
                        'message' => 'Cart Create Successfully',
                        'data' => $cart,
                    ], 200);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'cart not create try agin',
                    ], 400);
                }
            }else{
                $cart_new = new Cart([
                    'user_id' => $request->user_id,
                    'devices_id' => $request->devices_id,
                ]);

                if($cart_new->save()){
                    $cart_product = new CartProduct([
                        'cart_id' => $cart_new->id,
                        'product_id' => $request->product_id,
                        'store_id' => $request->store_id,
                        'vendor_type_id' => $request->vendor_type_id,
                        'product_count' => $request->product_count,
                    ]);

                    if($cart_product->save()){
                        if(isset($request->product_categorie_id)){
                            foreach($request->product_categorie_id as $pci){
                                $cart_product_categorie = new CartProductCategorie([
                                    'cart_id' => $cart_product->cart_id,
                                    'cart_product_id' => $cart_product->id,
                                    'product_categories_id' => $pci
                                ]);
                                $cart_product_categorie->save();
                            }
                        }
                    }

                    $cart_new->cart_product = $cart_product;
                    if($cart_product->save()){
                        return response()->json([
                            'status' => true,
                            'message' => 'Cart Create Successfully',
                            'data' => $cart_new,
                        ], 200);
                    }else{
                        return response()->json([
                            'status' => false,
                            'message' => 'cart not create try agin',
                        ], 400);
                    }
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'cart not create try agin',
                    ], 400);
                }
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
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $cart_id = $request->cart_id;
            $cart_product_id = $request->cart_product_id;
            if($cart_id != null && $cart_product_id != null){
                CartProductCategorie::where('cart_product_id',$cart_product_id)->delete();
                CartProduct::where('id',$cart_product_id)->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Cart Product Detail Delete Successfully',
                    'data' => $cart_id,
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Cart id and cart product id is required',
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getCart(Request $request){
        try {
            $devices_id = $request->devices_id;
            $user_id = auth()->user()->id;
            if($devices_id != null){
                $cart = Cart::where('user_id',$user_id)->where('devices_id',$devices_id)->first();

                if($cart){
                    $cart_product = DB::table('cart_products as cp')
                    ->join('products as p','p.id','=','cp.product_id')
                    ->selectRaw('cp.*,p.name as product_name,p.price as product_price,(p.price * cp.product_count) as product_total_price')
                    ->where('cart_id',$cart->id)
                    ->get();

                    if($cart_product){
                        $product_prize = 0;
                        foreach($cart_product as $cp){
                            $cart_product_categorie = DB::table('cart_product_categories as cpc')
                            ->join('product_categories as pc','pc.id','=','cpc.product_categories_id')
                            ->where('cpc.cart_product_id',$cp->id)
                            ->where('pc.product_id',$cp->product_id)
                            ->sum('pc.price');



                            $cp->product_total_price = $cp->product_total_price + ($cart_product_categorie * $cp->product_count);
                            $product_prize = $product_prize + $cp->product_total_price;
                        }
                        $cart->cart_product = $cart_product;
                        $data['product'] = $product_prize;
                        $data['deliver'] = "free";
                        $data['small_oder'] = 2;
                        $data['promo_code'] = null;
                        $data['total'] = $product_prize + 2;
                        $cart->cart_summary = $data;
                    }


                    return response()->json([
                        'status' => true,
                        'message' => 'Cart details',
                        'data' => $cart,
                    ], 200);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'cart not exits',
                    ], 400);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'try agin',
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function productPlus(Request $request){
        try {
            $cart_id = $request->cart_id;
            $product_id = $request->product_id;
            $cart_product_id = $request->cart_product_id;
            if($cart_product_id != null){
                $cart_product = CartProduct::where('id',$cart_product_id)->first();
                if($cart_product){
                    $cart_product->product_count = $cart_product->product_count + 1;
                    if($cart_product->save()){
                        return response()->json([
                            'status' => true,
                            'message' => 'Cart details',
                            'data' => $cart_product,
                        ], 200);
                    }
                }
                else{
                    return response()->json([
                        'status' => false,
                        'message' => 'cart_product not found',
                    ], 400);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'cart_product_id is required',
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function productMinus(Request $request){
        try {
            $cart_id = $request->cart_id;
            $product_id = $request->product_id;
            $cart_product_id = $request->cart_product_id;
            if($cart_product_id != null){
                $cart_product = CartProduct::where('id',$cart_product_id)->first();
                if($cart_product){
                    $cart_product->product_count = $cart_product->product_count - 1;
                    if($cart_product->save()){
                        return response()->json([
                            'status' => true,
                            'message' => 'Cart details',
                            'data' => $cart_product,
                        ], 200);
                    }
                }
                else{
                    return response()->json([
                        'status' => false,
                        'message' => 'cart_product not found',
                    ], 400);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'cart_id and product_id is required',
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function summary(Request $request){
        try {
            $cart_id = $request->cart_id;
            $devices_id = $request->devices_id;
            if($cart_id != null && $devices_id != null){
                $cart = Cart::where('id',$cart_id)->where('devices_id',$devices_id)->first();
                if($cart){
                    $cart_product = DB::table('cart_products as cp')
                    ->join('products as p','p.id','=','cp.product_id')
                    ->selectRaw('cp.id,cp.product_id,cp.product_count,(p.price * cp.product_count) as product_total_price')
                    ->where('cart_id',$cart->id)
                    ->get();

                    $product_prize = 0;
                    foreach($cart_product as $cp){
                        $cart_product_categorie = DB::table('cart_product_categories as cpc')
                            ->join('product_categories as pc','pc.id','=','cpc.product_categories_id')
                            ->where('cpc.cart_product_id',$cp->id)
                            ->where('pc.product_id',$cp->product_id)
                            ->sum('pc.price');

                        $product_prize = $product_prize + $cp->product_total_price + ($cart_product_categorie * $cp->product_count);
                    }

                    $data['product'] = $product_prize;
                    $data['deliver'] = "free";
                    $data['small_oder'] = 2;
                    $data['promo_code'] = null;
                    $data['total'] = $product_prize + 2;

                    return response()->json([
                        'status' => true,
                        'message' => 'Summary details',
                        'data' => $data,
                    ], 200);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'cart_id and devices_id is required',
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
