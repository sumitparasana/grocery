<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Helper;

use App\Models\Categorie;
use App\Models\Store;

class StoreCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorie = DB::table('categories as c')
        ->leftJoin('stores as s','s.id','=','c.store_id')
        ->join('vendor_types as v','v.id','=','c.vendor_type_id')
        ->selectRaw('c.*,s.name as store_name,v.name as store_type')
        ->get();

        return view('admin.categories.store.index',['data'=>$categorie]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['store'] = DB::table('stores')->get();
        return view('admin.categories.store.create',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'store_id' => 'nullable',
        ]);

        $store = DB::table('stores');

        if(isset($request->store_id)){
            $store = $store->where('id',$request->store_id)->first();
        }else{
            $store = $store->where('user_id',auth()->user()->id)->first();
        }

        if($store){
            $categorie =new Categorie([
                'name' => $request->name,
                'vendor_type_id' => $store->vendor_type_id,
                'store_id' => $store->id,
                'is_active' => $request->is_active,
                'in_oder' => $request->oder,
            ]);

            if($categorie->save()){
                return redirect('/store/categories');
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
        $request->validate([
            'name' => 'required',
            'store_id' => 'nullable',
        ]);
        
        $data['store'] = DB::table('stores')->get();

        $categorie = Categorie::where('id',$id)->first();
        return view('admin.categories.store.edit',['data'=>$data,'categorie'=>$categorie]);
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
            'name' => 'required',
            'store_id' => 'required',
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $store = DB::table('stores')->where('id',$request->store_id)->first();

        if($store){
            $categorie = Categorie::where('id',$id)->first();
            if($categorie){

                $categorie->name = $request->name;
                $categorie->vendor_type_id = $store->vendor_type_id;
                $categorie->store_id = $store->id;
                $categorie->is_active = $request->is_active;
                $categorie->in_oder = $request->oder;

                if($categorie->save()){
                    return redirect('/store/categories');
                }
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
