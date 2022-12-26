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
Route::get('/stores/details',[StoreController::class, 'storesDetails']);
Route::get('/stores/products',[ProductsController::class, 'getProducts']);
Route::get('/stores/productsByCategorie',[ProductsController::class, 'getProductsByCategorie']);
Route::get('/products/details',[ProductsController::class, 'productsDetails']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/stores', [StoreController::class, 'store']);
    Route::post('/categorie', [CategorieController::class, 'store']);
    Route::post('/products', [ProductsController::class, 'store']);
    Route::post('/product/categorie',[ProductCategorieController::class,'store']);
    Route::post('/cart',[CartController::class,'store']);
});
