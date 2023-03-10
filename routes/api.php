<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\VendorTypeController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\ProductCategorieController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PharmacyController;
use App\Http\Controllers\Api\StoreLikeController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Controllers\Api\OderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('otp/send', [OtpController::class, 'sendOTP']);
Route::post('otp/verify', [OtpController::class, 'verifyOTP']);
Route::get('/auth/logout', [AuthController::class, 'logout']);
Route::post('/password/reset/init', [AuthController::class, 'passwordReset']);

Route::get('/vendor/type',[VendorTypeController::class,'getVendorType']);
Route::get('/vendor/getStores',[StoreController::class, 'getStores']);
Route::get('/categorie/getCategorie',[CategorieController::class, 'getCategorie']);
Route::get('/stores/products',[ProductsController::class, 'getProducts']);
Route::get('/stores/productsByCategorie',[ProductsController::class, 'getProductsByCategorie']);
Route::get('/products/details',[ProductsController::class, 'productsDetails']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    //store
    Route::post('/stores', [StoreController::class, 'store']);
    Route::get('/stores/details',[StoreController::class, 'storesDetails']);
    Route::get('/stores/like',[StoreLikeController::class,'addLike']);

    // Home
    Route::get('/home/store/like',[StoreLikeController::class,'homeLikeStore']);
    Route::get('/home/store/rating',[StoreLikeController::class,'homeRatingStore']);

    // categorie
    Route::post('/categorie', [CategorieController::class, 'store']);

    // products
    Route::post('/products', [ProductsController::class, 'store']);
    Route::post('/product/categorie',[ProductCategorieController::class,'store']);
    Route::get('/product/like',[StoreLikeController::class,'addLikeProduct']);
    Route::get('/wishlist',[StoreLikeController::class,'getLikeProduct']);

    //cart
    Route::post('/cart',[CartController::class,'store']);
    Route::get('/cart/detail',[CartController::class,'getCart']);
    Route::get('/cart/product/plus',[CartController::class,'productPlus']);
    Route::get('/cart/product/minus',[CartController::class,'productMinus']);
    Route::get('/cart/delete',[CartController::class,'destroy']);

    Route::get('/cart/summary',[CartController::class,'summary']);

    //user
    Route::get('/user/detail',[UserController::class,'getUserDetail']);
    Route::post('user/detail/update',[UserController::class,'update']);
    Route::post('/user/address/create',[UserController::class,'createAddress']);
    Route::post('/user/address/update',[UserController::class,'updateAddress']);
    Route::get('/user/address',[UserController::class,'getAddress']);
    Route::get('/user/address/detail',[UserController::class,'getAddressDetail']);

    // pharmacy
    Route::post('/user/prescription/store',[PharmacyController::class,'storePrescription']);

    //Oder
    Route::post('/oder/create',[OderController::class,'store']);
    Route::get('/oder/getOder',[OderController::class,'getOder']);
    Route::get('/oder/getCancleOder',[OderController::class,'getCancleOder']);
    Route::get('/oder/getRefundOder',[OderController::class,'getRefundOder']);
    Route::get('/oder/getReturnOder',[OderController::class,'getReturnOder']);
    Route::get('/oder/detail/{id}',[OderController::class,'oderDetail']);
    Route::post('/oder/cancel/{id}',[OderController::class,'oderCancel']);
    Route::post('/oder/return/{id}',[OderController::class,'oderReturn']);

    // support
    Route::post('/support',[SupportController::class,'store']);

    // search
    Route::get('/search/home',[SupportController::class,'homeSearch']);

});
