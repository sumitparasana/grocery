<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreCategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\OderController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //user
    Route::get('/users',[UserController::class,'index']);
    Route::get('/users/create',[UserController::class,'create']);
    Route::post('/users',[UserController::class,'store']);
    Route::get('/users/edit/{id}',[UserController::class,'edit']);
    Route::post('/users/update/{id}',[UserController::class,'update']);

    //store
    Route::resource('stores', StoreController::class);

    // categories
    Route::resource('/store/categories', StoreCategoriesController::class);

    // product

    Route::resource('/products',ProductController::class);
    Route::resource('/product/categories',ProductCategoriesController::class);


    Route::get('/user/profile',function () {
        return view('admin.user.user-profile');
    });

    Route::get('/oder/new',[OderController::class,'indexNew']);
    Route::get('/oder/on-going',[OderController::class,'indexOnGoing']);
    Route::get('/oder/past',[OderController::class,'indexPast']);
    Route::get('/oder/detail/{id}',[OderController::class,'show']);

    Route::get('/oder/{id}/changeStatus',[OderController::class,'changeStatus']);

    Route::get('/eraning',function () {
        return view('admin.eraning.index');
    });

     Route::get('/transaction',function () {
        return view('admin.transaction.index');
     });

     Route::get('/vendor/{id}/getUser',[ServiceController::class,'getUserByVendor']);
     Route::get('/vendor/{id}/getStore',[ServiceController::class,'getStoreByVendor']);
     Route::get('/store/{id}/getCategorie',[ServiceController::class,'getCategorieByStore']);
     Route::get('/store/{id}/getProduct',[ServiceController::class,'getProductByStore']);
});

require __DIR__.'/auth.php';
