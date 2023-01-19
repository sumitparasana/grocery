<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Helper;

use App\Models\ProductCategorie;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $product_categories = DB::table('product_categories as pc')
        ->join('products as p','p.id','=','pc.product_id')
        ->leftJoin('stores as s','s.id','=','pc.store_id')
        ->leftJoin('categories as c','c.id','=','pc.categorie_id')
        ->selectRaw('pc.*,p.name as product_name,s.name as store_name,c.name as categorie_name');

        if(auth()->user()->role == 4){
            $product_categories = $product_categories->where('s.user_id',auth()->user()->id);
        }
        $product_categories = $product_categories->get();

        return view('admin.categories.product.index',['data'=>$product_categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['store'] = DB::table('stores as s')
        ->where('vendor_type_id',3)->get();

        $data['product'] = DB::table('products as p')
        ->join('stores as s','s.id','=','p.store_id')
        ->select('p.id','p.name')
        ->where('p.vendor_type_id',3);

        if(auth()->user()->role == 4){
            $data['product'] = $data['product']->where('s.user_id',auth()->user()->id);
        }

        $data['product'] = $data['product']->get();

        return view('admin.categories.product.create',['data'=>$data]);
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
            'product_id' => 'required',
            'price' => 'required'
        ]);

        $product = DB::table('products as p')
        ->where('id',$request->product_id)->first();

        if($product){
            $product_categorie = new ProductCategorie([
                'name' => $request->name,
                'price' => $request->price,
                'product_id' => $product->id,
                'categorie_id' => $product->categorie_id,
                'store_id' => $product->store_id,
                'vendor_type_id' => $product->vendor_type_id
            ]);

            if($product_categorie->save()){
                return redirect('/product/categories');
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
            'product_id' => 'required',
            'price' => 'required'
        ]);
        
        $data['store'] = DB::table('stores as s')
        ->where('vendor_type_id',3)->get();

        $data['product'] = DB::table('products as p')
        ->join('stores as s','s.id','=','p.store_id')
        ->select('p.id','p.name')
        ->where('p.vendor_type_id',3);

        if(auth()->user()->role == 4){
            $data['product'] = $data['product']->where('s.user_id',auth()->user()->id);
        }

        $data['product'] = $data['product']->get();

        $product_categorie = ProductCategorie::where('id',$id)->first();
        return view('admin.categories.product.edit',['data'=>$data,'product_categorie'=>$product_categorie]);
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
            'store_id' => 'nullable',
            'product_id' => 'required',
            'price' => 'required'
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $product = DB::table('products as p')
        ->where('id',$request->product_id)->first();

        if($product){
            $product_categorie = ProductCategorie::where('id',$id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'product_id' => $product->id,
                'categorie_id' => $product->categorie_id,
                'store_id' => $product->store_id,
                'vendor_type_id' => $product->vendor_type_id
            ]);

            if($product_categorie){
                return redirect('/product/categories');
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
