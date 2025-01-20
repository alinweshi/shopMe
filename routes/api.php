<?php

use App\Http\Controllers\ApiControllers\AddressController;
use App\Http\Controllers\ApiControllers\CartController;
use App\Http\Controllers\ApiControllers\MyFatoorahWebhookController;
use App\Http\Controllers\ApiControllers\OrderController;
use App\Http\Controllers\ApiControllers\PaymentController;
use App\Http\Controllers\ApiControllers\ProductController;
use App\Http\Controllers\ApiControllers\ShippingMethodController;
use App\Http\Controllers\ApiControllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user()->load('addresses');
})->middleware('auth:sanctum');

Route::get('/test-email', function () {
    try {
        Mail::raw('This is a test email.', function ($message) {
            $message->to('alinweshi@gmail.com')
                ->subject('Test Email');
        });

        return 'Email sent successfully.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}/update', [ProductController::class, 'update']);
Route::delete('/products/{id}/delete', [ProductController::class, 'delete']);
route::prefix('users')->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
    // Route::get('{id}/profile', [UserAuthController::class, 'profile']);
    Route::post('forget-password', [UserAuthController::class, 'forgotPassword']);
    Route::post('reset-password', [UserAuthController::class, 'resetPassword']);
    Route::post('logout', [UserAuthController::class, 'logout'])
        ->middleware('auth:sanctum');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::get('/cart/view', [CartController::class, 'viewCart']);
    Route::put('/cart/update/{id}', [CartController::class, 'updateCart']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeCartItem']);
    Route::delete('/cart/clear', [CartController::class, 'clearCart']);
    Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon']);
    Route::get('/shipping-methods', [ShippingMethodController::class, 'index']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{orderId}', [OrderController::class, 'show']);
    Route::post('orders/create', [OrderController::class, 'store']);
    Route::put('/orders/{orderId}/status', [OrderController::class, 'updateStatus']);
    Route::get('/orders/confirmation/{orderId}', [OrderController::class, 'confirmation']);
    Route::get('/orders/edit/{orderId}', [OrderController::class, 'edit']);
    Route::post('/initiate-payment', [PaymentController::class, 'initiatePayment']);
    Route::post('/execute-payment', [PaymentController::class, 'executePayment']);
    Route::get('/payment/error', [PaymentController::class, 'handleError']);
    Route::post('send-payment', [PaymentController::class, 'sendPayment']);

    Route::get('/payment-methods', [PaymentController::class, 'paymentMethod']);
    Route::post('/payment/confirmation', [PaymentController::class, 'handlePaymentConfirmation']);
    Route::post('/payment/updateStatus', [PaymentController::class, 'updatePaymentStatus']);
    Route::post('webhook/myfatoorah', [MyFatoorahWebhookController::class, 'handle']);
    Route::post('/payment/status', [PaymentController::class, 'getPaymentStatus']);
});
Route::post('/payment/callback', [PaymentController::class, 'handleCallback']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/addresses/update', [AddressController::class, 'addNewAddress']);
});
