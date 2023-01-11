<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Store;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store = DB::table('stores as s')
        ->join('users as u','s.user_id','=','u.id')
        ->leftJoin('roles as r', 'u.role','=','r.id')
        ->selectRaw('s.*,u.id as user_id,u.name as user_name,r.name as user_role')
        ->get();
        return view('admin.store.index',['data'=>$store]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['user'] = User::whereIn('role',['2','3','4'])->get();

        return view('admin.store.create',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
