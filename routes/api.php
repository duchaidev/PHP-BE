<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\TourController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;

// tour
Route::get('/tour', [TourController::class, 'index']);
Route::post('/tour', [TourController::class, 'store']);
Route::get('/tour/{id}', [TourController::class, 'show']);
Route::put('/tour/{id}', [TourController::class, 'update']);
Route::delete('/tour/{id}', [TourController::class, 'destroy']);

// Posts
Route::get('/post', [PostController::class, 'index']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::post('/post', [PostController::class, 'store']);
Route::put('/post/{id}', [PostController::class, 'update']);
Route::delete('/post/{id}', [PostController::class, 'destroy']);

// Bookings
Route::post('booking', [BookingController::class, 'createBookingService']);
Route::get('booking', [BookingController::class, 'getAllBookingService']);
Route::get('booking/{id}', [BookingController::class, 'getBookingByIdService']);
Route::put('booking/{id}', [BookingController::class, 'updateBookingByIdService']);


// // Customers
// Route::get('/customers', [CustomerController::class, 'index']);
// Route::post('/customers', [CustomerController::class, 'store']);
// Route::get('/customers/{id}', [CustomerController::class, 'show']);
// Route::put('/customers/{id}', [CustomerController::class, 'update']);
// Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);

// contact
Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);
Route::put('/contact/{id}', [ContactController::class, 'update']);

// Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
