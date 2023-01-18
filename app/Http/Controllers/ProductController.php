<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Helper;

use App\Models\Products;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = DB::table('products as p')
        ->join('stores as s','s.id','=','p.store_id')
        ->leftJoin('vendor_types as v','v.id','=','s.vendor_type_id')
        ->leftJoin('categories as c','c.id','=','p.categorie_id')
        ->selectRaw('p.*,s.name as store_name,v.name as store_type,c.name as categorie_name');

        if(auth()->user()->role != 1){
            $product = $product->where('s.user_id',auth()->user()->id);
        }

        $product = $product->get();

        return view('admin.product.index',['data'=>$product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['stores'] = DB::table('stores as s')->get();

        $data['categories'] = DB::table('categories as c')
        ->join('stores as s','s.id','=','c.store_id')
        ->select('c.id','c.name',);

        if(auth()->user()->role != 1){
            $data['categories'] = $data['categories']->where('s.user_id',auth()->user()->id);
        }

        $data['categories'] = $data['categories']->get();

        return view('admin.product.create',['data'=>$data]);
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
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',
            'discount_price' => 'nullable',
            'price' => 'required',
            'capacity' => 'nullable',
            'available_qty' => 'nullable',
            'store_id' => 'nullable',
            'categorie_id' => 'required'
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $store = DB::table('stores');

        if(auth()->user()->role == 1){
            $store = $store->where('id',$request->store_id);
        }else{
            $store = $store->where('user_id',auth()->user()->id);
        }
        $store = $store->first();

        if($store){
            if(!empty($request->file('image'))){
                $image_data = Helper::fileUploadApi('upload/products',$request->file('image'));
            }

            $product = Products::create([
                'name' => $request->name,
                'vendor_type_id' => $store->vendor_type_id,
                'image' => $image_data['image_name'],
                'image_path' => $image_data['url'],
                'description' => $request->description,
                'discount_price' => $request->discount_price,
                'price' => $request->price,
                'capacity' => $request->capacity,
                'available_qty' => $request->available_qty,
                'store_id' => $store->id,
                'categorie_id' => $request->categorie_id,
                'deliverable' => $request->deliverable,
            ]);

            if(!$product){
                if (File::exists($image_data['url'])) {
                    File::delete($image_data['url']);
                }
            }
        }

        return redirect('/products');
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
        $product = Products::where('id',$id)->first();
        $data['stores'] = DB::table('stores as s')->get();

        $data['categories'] = DB::table('categories as c')
        ->join('stores as s','s.id','=','c.store_id')
        ->select('c.id','c.name',);

        if(auth()->user()->role != 1){
            $data['categories'] = $data['categories']->where('s.user_id',auth()->user()->id);
        }

        $data['categories'] = $data['categories']->get();
        return view('admin.product.edit',['data'=>$data,'product'=>$product]);
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
            'image' => 'null',
            'description' => 'required',
            'discount_price' => 'nullable',
            'price' => 'required',
            'capacity' => 'nullable',
            'available_qty' => 'nullable',
            'store_id' => 'nullable',
            'categorie_id' => 'required',
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $product = Products::where('id',$id)->first();

        if($product){
            $store = DB::table('stores');

            if(auth()->user()->role == 1){
                $store = $store->where('id',$request->store_id);
            }else{
                $store = $store->where('user_id',auth()->user()->id);
            }
            $store = $store->first();
            if($store){
                if(!empty($request->file('image'))){
                    if (File::exists($product->image_path)) {
                        File::delete($product->image_path);
                    }
                    $image_data = Helper::fileUploadApi('upload/products',$request->file('image'));
                    $product->image = $image_data['image_name'];
                    $product->image_path = $image_data['url'];
                }

                $product->name = $request->name;
                $product->vendor_type_id = $store->vendor_type_id;
                $product->description = $request->description;
                $product->price = $request->price;
                $product->capacity = $request->capacity;
                $product->available_qty = $request->available_qty;
                $product->store_id = $store->id;
                $product->categorie_id = $request->categorie_id;
                $product->deliverable = $request->deliverable;

                $product->save();
            }
        }


        return redirect('/products');
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
