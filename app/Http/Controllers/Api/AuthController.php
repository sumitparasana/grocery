<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use App\Models\Referral;
use App\Models\User;
// use App\Models\Vehicle;
// use App\Models\Vendor;
// use App\Traits\FirebaseAuthTrait;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'phone' => 'required|unique:users',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' =>$request->phone,
                'password' => Hash::make($request->password),
                'role' => 'customer'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'phone' => 'required',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['phone', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'phone & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('phone', $request->phone)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        if(auth()->user()){
            $user = User::find(auth()->user()->id);
            if (!empty($user)) {
                // if ($user->hasAnyRole('driver')) {
                //     $user->is_online = 0;
                //     $user->save();
                // }
                Auth::logout();
            }
            return response()->json([
                "message" => "Logout successful"
            ]);
        }else{
            return response()->json([
                "message" => "Allready logout"
            ]);
        }
    }

    public function passwordReset(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'phone' => 'required',
            ],
            $messages = [
                'phone.exists' => __('Phone not associated with any account'),
            ]
        );

        if ($validator->fails()) {

            return response()->json([
                "message" => $this->readalbeError($validator),
            ], 400);
        }

        //
        // $phone = PhoneNumber::make($request->phone);

        $user = User::where('phone', 'like', '%' . $request->phone . '')->first();

        if (empty($user)) {
            return response()->json([
                "message" => __("There is no account accoutiated with provided phone number ") . $request->phone . "",
            ], 400);
        }

        try {
                $user = User::where("phone", $request->phone)->firstorfail();
                $user->password = Hash::make($request->password);
                $user->Save();

                return response()->json([
                    "message" => __("Account Password Updated Successfully"),
                ], 200);
            // }
        } catch (\Expection $ex) {
            return response()->json([
                "message" => $ex->getMessage(),
            ], 400);
        }
    }

    public function authObject($user)
    {

        // if (!$user->is_active) {
        //     throw new Exception(__("User Account is inactive"), 1);
        // }

        $user = User::find($user->id);
        // $vendor = Vendor::find($user->vendor_id);
        // $vehicle = Vehicle::active()->where('driver_id', $user->id)->first();
        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json([
            "token" => $token,
            // "fb_token" => $this->fbToken($user),
            "type" => "Bearer",
            "message" => __("User login successful"),
            "user" => $user,
            // "vehicle" => $vehicle,
            // "vendor" => $vendor,
        ]);
    }
}
