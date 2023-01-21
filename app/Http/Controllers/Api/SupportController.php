<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Helper;
use File;

class SupportController extends Controller
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
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'concern' => 'required',
                'message' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $support = new Support([
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'concern' => $request->concern,
                'message' => $request->message,
            ]);

            if($support->save()){
                return response()->json([
                    'status' => true,
                    'message' => 'Send Query Successfully',
                    'data' => $support,
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'try agin',
            ], 401);
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
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function show(Support $support)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function edit(Support $support)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Support $support)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function destroy(Support $support)
    {
        //
    }

    public function homeSearch(Request $request){
        try {
            $data = DB::table('products as p')
            ->leftJoin('categories as c','c.id','=','p.categorie_id')
            ->leftJoin('stores as s','s.id','=','p.store_id')
            ->selectRaw('p.id as product_id,p.name as product_name,p.price as product_price,c.id as categorie_id,c.name as categorie_name,s.id as store_id,s.name as store_name,s.vendor_type_id as vendor_type_id');

            if(isset($request->vendor_type_id) && $request->vendor_type_id != ''){
                $data = $data->where('s.vendor_type_id',$request->vendor_type_id);
            }

            if(isset($request->store_id) && $request->store_id != ''){
                $data = $data->where('s.id',$request->store_id);
            }

            $filter = $request->get('query','');
            if(isset($request->query) && $request->query != ''){
                $data = $data->where(function($query) use ($filter) {
                    $query->where('p.name','LIKE',"%{$filter}%")
                    ->orWhere('c.name','LIKE',"%{$filter}%")
                    ->orWhere('s.name','LIKE',"%{$filter}%")
                    ->orWhere('p.price','LIKE',"%{$filter}%");
                });
            }

            $data = $data->get();

            return response()->json([
                'status' => true,
                'message' => 'search result',
                'data' => $data,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


}
