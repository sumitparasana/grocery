<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Helper;
use File;

class PharmacyController extends Controller
{
    public function storePrescription(Request $request){
        try {
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'image' => 'required',
                'remark' => 'required',
                'address_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!empty($request->file('image'))){
                $image_data = Helper::fileUploadApi('upload/pharmacy/prescription',$request->file('image'));
            }

            $prescription = new Prescription([
                'user_id' => auth()->user()->id,
                'image' => $image_data['image_name'],
                'image_path' => $image_data['url'],
                'remark' => $request->remark,
                'address_id' => $request->address_id
            ]);

            if($prescription->save()){
                return response()->json([
                    'status' => true,
                    'message' => 'prescription image add Successfully',
                    'data' => $prescription,
                ], 200);
            }else{
                if (File::exists($image_data['url'])) {
                    File::delete($image_data['url']);
                }
                return response()->json([
                    'status' => false,
                    'message' => 'prescription Not add Successfully',
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
