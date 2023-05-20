<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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
    return view('welcome');
});

// rutas de ciudad
Route::get('api/city/showAll', [CityController::class, 'showAll'])->name('showAll');
Route::post('api/city/registerCity', [CityController::class, 'registerCity'])->name('registerCity');
Route::get('api/city/showCity/{id}', [CityController::class, 'showCity'])->name('showCity');
Route::put('api/city/updateCity/{id}', [CityController::class, 'updateCity'])->name('updateCity');

// rutas de cliente
Route::get('api/customer/showAll', [CustomerController::class, 'showAll'])->name('showAll');
Route::post('api/customer/registerCustomer', [CustomerController::class, 'registerCustomer'])->name('registerCustomer');
Route::get('api/customer/showCustomer/{id}', [CustomerController::class, 'showCustomer'])->name('showCustomer');
Route::put('api/customer/updateCustomer/{id}', [CustomerController::class, 'updateCustomer'])->name('updateCustomer');

// rutas de producto
Route::get('api/product/showAll', [ProductController::class, 'showAll'])->name('showAll');
Route::post('api/product/registerProduct', [ProductController::class, 'registerProduct'])->name('registerProduct');
Route::get('api/product/showProduct/{id}', [ProductController::class, 'showProduct'])->name('showProduct');
Route::put('api/product/updateProduct/{id}', [ProductController::class, 'updateProduct'])->name('updateProduct');

// rutas de orden

Route::get('api/order/getProductsAsign/{id}', [OrderController::class, 'getProductsAsign'])->name('getProductsAsign');
Route::get('api/order/showAll', [OrderController::class, 'showAll'])->name('showAll');
Route::post('api/order/registerOrder', [OrderController::class, 'registerOrder'])->name('registerOrder');
Route::get('api/order/showOrder/{id}', [OrderController::class, 'showOrder'])->name('showOrder');

Route::post('api/order/asignProducts', [OrderController::class, 'asignProducts'])->name('asignProducts');
Route::get('api/order/deleteProductsAsign/{id}', [OrderController::class, 'deleteProductsAsign'])->name('deleteProductsAsign');

Route::post('api/order/asignarProduct', [OrderController::class, 'asignarProduct'])->name('asignarProduct');
Route::put('api/order/updateOrder', [OrderController::class, 'updateOrder'])->name('updateOrder');
