<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Helper;
use File;

class UserController extends Controller
{
    //
    public function getUserDetail(Request $request){
        try {
            $user = auth()->user();

            if($user){
                return response()->json([
                    'status' => true,
                    'message' => 'User Details',
                    'data' => $user,
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'user not found',
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request){
        try {
            $user_id = auth()->user();

            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required',
                'password' => 'nullable',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = auth()->user();

            if(!empty($request->file('image'))){
                if (File::exists($user->image_path)) {
                    File::delete($user->image_path);
                }
                $image_data = Helper::fileUploadApi('upload/users',$request->file('image'));
            }

            $user_update = User::where('id',$user->id)->first();
            $user_update->name = $request->name;
            $user_update->email = $request->email;
            if(isset($request->password) && $request->password != null){
                $user_update->password = Hash::make($request->password);
            }
            $user_update->image = $image_data ? $image_data['image_name'] : $user->image;
            $user_update->image_path = $image_data ? $image_data['url'] : $user->image_path;
            if($user_update->save()){
                return response()->json([
                    'status' => true,
                    'message' => 'User Details Update Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'try agin'
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function createAddress(Request $request){
        try {
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'address_type' => 'required',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(auth()->user()){
                $address = new Address([
                    'user_id' => $request->user_id,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'address_type' => $request->address_type,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude
                ]);
                if($address->save()){
                    return response()->json([
                        'status' => true,
                        'message' => 'User Address Create Successfully',
                        'data' => $address
                    ], 200);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'user not found'
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function updateAddress(Request $request){
        try {
            $validateUser = Validator::make($request->all(),
            [
                'address_id' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'address_type' => 'required',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(auth()->user()){
                $address = Address::where('id',$request->address_id)->first();
                if($address){
                    $address->name = $request->name;
                    $address->phone = $request->phone;
                    $address->address = $request->address;
                    $address->address_type = $request->address_type;
                    $address->latitude = $request->latitude;
                    $address->longitude = $request->longitude;
                    if($address->save()){
                        return response()->json([
                            'status' => true,
                            'message' => 'User Address Update Successfully',
                            'data' => $address
                        ], 200);
                    }
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'address not found'
                    ], 401);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'user not found'
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getAddress(Request $request){
        try {
            $address = Address::where('user_id',auth()->user()->id)->get();

            return response()->json([
                'status' => true,
                'message' => 'User Address Details',
                'data' => $address
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getAddressDetail(Request $request){
        try {
            $address = Address::where('id',$request->id)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Address Details',
                'data' => $address
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
