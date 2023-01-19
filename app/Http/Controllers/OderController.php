<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Helper;

use App\Models\Oder;

class OderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexNew()
    {
        $oder = DB::table('oders as o')
        ->leftJoin('users as u','o.user_id','=','u.id')
        ->leftJoin('addresses as a','a.id','=','o.delivery_address')
        ->selectRaw('o.*,u.name as user_name,a.name as address')
        ->where('o.status',1)->get();
        return view('admin.oder.new',['data'=> $oder]);
    }

    public function indexOnGoing()
    {
        $oder = DB::table('oders as o')
        ->leftJoin('users as u','o.user_id','=','u.id')
        ->leftJoin('addresses as a','a.id','=','o.delivery_address')
        ->selectRaw('o.*,u.name as user_name,a.name as address')
        ->where('o.status',15)->get();
        return view('admin.oder.on-going',['data' => $oder]);
    }

    public function indexPast()
    {
        $oder = DB::table('oders as o')
        ->leftJoin('users as u','o.user_id','=','u.id')
        ->leftJoin('addresses as a','a.id','=','o.delivery_address')
        ->selectRaw('o.*,u.name as user_name,a.name as address')
        ->where('o.status',7)->get();
        return view('admin.oder.past',['data' => $oder]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oder = DB::table('oders as o')
        ->join('users as u','u.id','=','o.user_id')
        ->leftJoin('addresses as a','a.id','=','o.delivery_address')
        ->selectRaw('o.*,u.name as user_name,a.name as address,a.phone as delivery_phone')
        ->where('o.id',$id)
        ->first();

        $data['oder'] = $oder;

        if($oder){
            $oder_product = DB::table('oder_products as op')
            ->leftJoin('products as p','p.id','=','op.product_id')
            ->selectRaw('op.*,p.name as product_name,p.image as product_image')
            ->where('op.oder_id',$oder->id)
            ->get();

            $data['oder_product'] = $oder_product;

            $product_price = 0;
            foreach($oder_product as $op){

                $product_price = $product_price + ($op->product_price * $op->product_count);
            }
            $data['total_price'] = $product_price;
            $data['product_discount'] = 0;
            $data['grant_total'] = $product_price;
        }

        $data['status'] = DB::table('statuses')->select('id','name')->get();

        return view('admin.oder.detail',['data' => $data]);
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

    public function changeStatus(Request $request,$id){
        $oder = Oder::where('id',$id)->first();

        if($oder){
            $oder->status = $request->status;
            if($oder->save()){
                return redirect()->back()->with('message', 'status change successfully');
            }
        }
        return redirect()->back()->with('error', 'status not change');
    }
}
