<?php

use Illuminate\Support\Facades\Route;
// use App\Htpp\Controllers\CategoriesController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum'])->group(function(){
    //Category
    Route::resource('categories', CategoriesController::class);
    Route::get('/api/categories', 'CategoriesController@getCategoriesJson');
    //Brand
    Route::resource('brands', BrandsController::class);
    //Size
    Route::resource('sizes', SizesController::class);
    //Product
    Route::resource('products', ProductsController::class);
});
