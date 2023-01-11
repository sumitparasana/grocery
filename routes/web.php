<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
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

    // route::get('/stores',function () {
    //     return view('admin.store.index');
    // });

    // Route::get('/stores/create',function () {
    //     return view('admin.store.create');
    // });

    Route::get('/stores/categories',function () {
        return view('admin.categories.store.index');
    });

    Route::get('/stores/categories/create',function () {
        return view('admin.categories.store.create');
    });

    route::get('/product',function () {
        return view('admin.product.index');
    });

    Route::get('/product/create',function () {
        return view('admin.product.create');
    });

    Route::get('/product/categories',function () {
        return view('admin.categories.product.index');
    });

    Route::get('/product/categories/create',function () {
        return view('admin.categories.product.create');
    });

    Route::get('/user/profile',function () {
        return view('admin.user.user-profile');
    });

    Route::get('/oder/new',function () {
        return view('admin.oder.new');
    });

    Route::get('/oder/on-going',function () {
        return view('admin.oder.on-going');
    });

    Route::get('/oder/past',function () {
        return view('admin.oder.past');
    });

    Route::get('/oder/detail',function () {
        return view('admin.oder.detail');
    });

    Route::get('/eraning',function () {
        return view('admin.eraning.index');
    });

     Route::get('/transaction',function () {
        return view('admin.transaction.index');
     });
});

require __DIR__.'/auth.php';
