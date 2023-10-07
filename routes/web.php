<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageCrudeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products',[ImageCrudeController::class,'all_products'])->name('all.product');
Route::get('/add-new-product',[ImageCrudeController::class,'add_new_products'])->name('add.product');
Route::post('/store-product',[ImageCrudeController::class,'store_product'])->name('store.product');