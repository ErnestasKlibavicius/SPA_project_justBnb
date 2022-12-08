<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\BookableController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\BookablePriceController;
use App\Http\Controllers\Api\BookableReviewController;
use App\Http\Controllers\Api\BookingByReviewController;
use App\Http\Controllers\Api\BookableAvailabilityController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

// Route::group(['middleware' => ['auth:api']], function () {

    Route::apiResource('bookables', BookableController::class);
    Route::get('bookables/{bookable}/availability', BookableAvailabilityController::class)->name('bookables.availability.show');
    Route::get('bookables/{bookable}/reviews', BookableReviewController::class)->name('bookables.reviews.index');
    Route::get('bookables/{bookable}/price', BookablePriceController::class)->name('bookables.price.show');

    Route::get('/booking-by-review/{reviewKey}', BookingByReviewController::class)->name('booking.by-review.show');

    Route::apiResource('reviews', ReviewController::class);

    Route::post('checkout', CheckoutController::class)->name('checkout');

    Route::apiResource('users', UserController::class);

    Route::apiResource('comments', CommentController::class)->except(['store']);
    Route::post('/comments/{post_id}/user/{user_id}', [CommentController::class, 'store'])->name('comments.store');

// });
