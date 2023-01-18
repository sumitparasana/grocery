<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Helper;

use App\Models\User;
use App\Models\Store;
use App\Models\Tage;

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

        if(auth()->user()->role == 1){
            return view('admin.store.index',['data'=>$store]);
        }else{
            $store_id = Store::where('user_id',auth()->user()->id)->pluck('id')->first();
            return redirect('/stores/'.$store_id.'/edit');
        }
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
            'user_id' => 'required',
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

        $user = User::where('id',$request->user_id)->first();
        if($user){
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
                'user_id' => $user->id,
            ]);

            if($store){
                foreach($request->tage as $t){
                    $tage = Tage::create([
                        'name' => $t,
                        'vendor_type_id' => $request->vendor_type_id,
                        'store_id' => $store->id,
                    ]);
                }

                return redirect('/stores');
            }
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
        $data['user'] = User::whereIn('role',['2','3','4'])->get();

        $store = Store::where('id',$id)->first();
        return view('admin.store.edit',['data'=>$data,'store'=>$store]);
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
        $validateUser = Validator::make($request->all(),
        [
            'user_id' => 'required',
            'vendor_type_id' => 'required',
            'name' => 'required',
            'image' => 'nullable',
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

        $store = Store::where('id',$id)->first();

        if($store){
            if(!empty($request->file('image'))){
                if (File::exists($store->image_path)) {
                    File::delete($store->image_path);
                }
                $image_data = Helper::fileUploadApi('upload/store',$request->file('image'));
                $store->image = $image_data['image_name'];
                $store->image_path = $image_data['url'];
            }

            $store->name = $request->name;
            $store->vendor_type_id = $request->vendor_type_id;
            $store->user_id = $request->user_id;
            $store->description = $request->description;
            $store->address = $request->address;
            $store->zip_code = $request->zip_code;
            $store->location = $request->location;
            $store->delivery_prize = $request->delivery_prize;
            $store->delivery_time = $request->delivery_time;

            if($store->save()){
                return redirect('/stores');
            }
        }
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
