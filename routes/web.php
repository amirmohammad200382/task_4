<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\checkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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
    return redirect()->route('login');
});
Route::post('auth/register', [UserController::class, 'createUser'])->name('register');
Route::get('auth/logout', [AuthController::class, 'logoutUser'])->middleware('auth:sanctum')->name('logoutUser');
Route::any('auth/login', [AuthController::class, 'loginUser'])->name('loginUser');



Route::get('/login', function () {
    return view('authorize.login');
})->name('login');

//Route::view('/register', 'authorize.register')->name('register');

Route::get('/workplace', function () {
    return view('workplace');
})->name('workplace');

Route::get('/registerView', function () {
    return view('authorize.register');
})->name('registerView');

//users
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::patch('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');


//products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::patch('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');

//orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::patch('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
Route::delete('/orders/{id}/delete', [OrderController::class, 'destroy'])->name('orders.destroy');


Route::get('/check/create', [checkController::class, 'create'])->name('check.create');
Route::get('/check/index', [checkController::class, 'index'])->name('check.index');
Route::post('/check/store', [checkController::class, 'store'])->name('check.store');
Route::get('/check/{id}/edit', [checkController::class, 'edit'])->name('check.edit');
Route::put('/check/{id}', [checkController::class, 'update'])->name('check.update');
Route::delete('/check/{id}/delete', [checkController::class, 'destroy'])->name('check.destroy');
