<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorType;

class VendorTypeController extends Controller
{
    //
    public function getVendorType(Request $request){
        try {
            $vendor_type = VendorType::get();

            return response()->json([
                'status' => true,
                'message' => 'Store list By vendor type id',
                'data' => $vendor_type,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
