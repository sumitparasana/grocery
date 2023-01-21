<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Oder;
use App\Models\OderProduct;
use App\Models\OderProductCategorie;
use App\Models\CartProduct;
use App\Models\CartProductCategorie;
use App\Models\Products;
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
            $oder->paid_amount = 0;

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
                            'product_price' => $p->price,
                            'delivery_status' => 1,
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

                            Products::productSell($p->id);
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

    public function getOder(){
        try {
            $oder = Oder::leftJoin('statuses as s','s.id','=','oders.status')
                ->where('user_id',auth()->user()->id)
                ->selectRaw('oders.*,DATE_FORMAT(oders.creation_date,"%d-%b-%Y %h:%i %p") as oder_date,s.name as status_name')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'oder details',
                'data' => $oder,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getCancleOder(){
        try {
            $oder = Oder::leftJoin('statuses as s','s.id','=','oders.status')
                ->where('user_id',auth()->user()->id)
                ->where('starus',9)
                ->selectRaw('oders.*,DATE_FORMAT(oders.creation_date,"%d-%b-%Y %h:%i %p") as oder_date,s.name as status_name')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'oder details',
                'data' => $oder,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getRefundOder(){
        try {
            $oder = Oder::leftJoin('statuses as s','s.id','=','oders.status')
                ->where('user_id',auth()->user()->id)
                ->where('starus',11)
                ->selectRaw('oders.*,DATE_FORMAT(oders.creation_date,"%d-%b-%Y %h:%i %p") as oder_date,s.name as status_name')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'oder details',
                'data' => $oder,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getReturnOder(){
        try {
            $oder = Oder::leftJoin('statuses as s','s.id','=','oders.status')
                ->where('user_id',auth()->user()->id)
                ->where('starus',16)
                ->selectRaw('oders.*,DATE_FORMAT(oders.creation_date,"%d-%b-%Y %h:%i %p") as oder_date,s.name as status_name')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'oder details',
                'data' => $oder,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function oderDetail($id){
        try {
            $oder = DB::table('oders as o')
            ->leftJoin('statuses as s','s.id','=','o.status')
            ->leftJoin('addresses as a','a.id','=','o.delivery_address')
            ->selectRaw('o.*,DATE_FORMAT(o.creation_date,"%d-%b-%Y %h:%i %p") as oder_date,s.name as oder_status_name,a.name as address_name,a.phone as address_phone,a.address as address,(o.amount - o.paid_amount) as skip_for_pay')
            ->where('o.id',$id)->first();

            if($oder){
                $oder_product = DB::table('oder_products as op')
                ->leftJoin('statuses as s','s.id','=','op.delivery_status')
                ->leftJoin('products as p','p.id','=','op.product_id')
                ->selectRaw('op.*,s.name as oder_product_status,p.name as product_name,p.image_path as product_image')
                ->where('op.oder_id',$oder->id)->get();

                $oder->oder_product = $oder_product;

                return response()->json([
                    'status' => true,
                    'message' => 'oder details',
                    'data' => $oder,
                ], 200);
            }else{
                return response()->json([
                    'status' => true,
                    'message' => 'oder product not found',
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function oderCancel(Request $request,$id){
        try {
            $oder = Oder::where('id',$id)->first();
            if($oder){
                $oder->status = 9;
                if($oder->save()){
                    return response()->json([
                        'status' => true,
                        'message' => 'oder details',
                        'data' => $oder,
                    ], 200);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'oder not cancle',
                    ], 401);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'oder id not found',
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function oderReturn(Request $request,$id){
        try {
            $oder = Oder::where('id',$id)->first();
            if($oder){
                $oder->status = 16;
                if($oder->save()){
                    return response()->json([
                        'status' => true,
                        'message' => 'oder details',
                        'data' => $oder,
                    ], 200);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'oder not cancle',
                    ], 401);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'oder id not found',
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}


// Pending — Customer started the checkout process but did not complete it. Incomplete orders are assigned a "Pending" status and can be found under the More tab in the View Orders screen.
// Awaiting Payment — Customer has completed the checkout process, but payment has yet to be confirmed. Authorize only transactions that are not yet captured have this status.
// Awaiting Fulfillment — Customer has completed the checkout process and payment has been confirmed.
// Awaiting Shipment — Order has been pulled and packaged and is awaiting collection from a shipping provider.
// Awaiting Pickup — Order has been packaged and is awaiting customer pickup from a seller-specified location.
// Partially Shipped — Only some items in the order have been shipped.
// Completed — Order has been shipped/picked up, and receipt is confirmed; client has paid for their digital product, and their file(s) are available for download.
// Shipped — Order has been shipped, but receipt has not been confirmed; seller has used the Ship Items action. A listing of all orders with a "Shipped" status can be found under the More tab of the View Orders screen.
// Cancelled — Seller has cancelled an order, due to a stock inconsistency or other reasons. Stock levels will automatically update depending on your Inventory Settings. Cancelling an order will not refund the order. This status is triggered automatically when an order using an authorize-only payment gateway is voided in the control panel before capturing payment.
// Declined — Seller has marked the order as declined.
// Refunded — Seller has used the Refund action to refund the whole order. A listing of all orders with a "Refunded" status can be found under the More tab of the View Orders screen.
// Disputed — Customer has initiated a dispute resolution process for the PayPal transaction that paid for the order or the seller has marked the order as a fraudulent order.
// Manual Verification Required — Order on hold while some aspect, such as tax-exempt documentation, is manually confirmed. Orders with this status must be updated manually. Capturing funds or other order actions will not automatically update the status of an order marked Manual Verification Required.
// Partially Refunded — Seller has partially refunded the order.

