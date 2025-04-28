<?php

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebCustomerController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\ApiControllers\RoleController;
use App\Http\Controllers\ApiControllers\OrderController;
use App\Http\Controllers\ApiControllers\AddressController;
use App\Http\Controllers\ApiControllers\ApiCartController;
use App\Http\Controllers\ApiControllers\PaymentController;
use App\Http\Controllers\ApiControllers\ProductController;
use App\Http\Controllers\ApiControllers\UserAuthController;
use App\Http\Controllers\ApiControllers\PermissionController;
use App\Http\Controllers\ApiControllers\JwtAdminAuthController;
use App\Http\Controllers\ApiControllers\NotificationController;
use App\Http\Controllers\ApiControllers\PermissionRoleController;
use App\Http\Controllers\ApiControllers\ShippingMethodController;
use  App\DesignPatterns\Structural\Adapter\PaymentAdapterController;
use App\DesignPatterns\Behavioural\Strategy\OrderStrategyController;
use App\Http\Controllers\ApiControllers\MyFatoorahWebhookController;
use App\DesignPatterns\Structural\Decorator\Shipping\ShippingDecorator;
use App\DesignPatterns\Behavioural\Observer\User\UserObserverController;
use App\DesignPatterns\Structural\Decorator\Coffee\CoffeeDecoratorController;
use App\DesignPatterns\Structural\Decorator\Shipping\ShippingDecoratorController;
use App\DesignPatterns\Structural\Decorator\Transport\TransportDecoratorController;
use App\Http\Controllers\ApiControllers\BookingsController;

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
/*----------------------------------flights-------------------------------------*/
Route::post('book/{ticket}/{quantity}/{user_id}', [BookingsController::class, 'store']);

/*------------------------------------------------------------------------------*/

Route::post('transport', [TransportDecoratorController::class, 'transport']);
Route::post('get-shipping', [ShippingDecoratorController::class, 'getShipping']);
Route::post('coffee-cost/{coffee_type}', [CoffeeDecoratorController::class, 'MakeCoffeeCost']);
Route::post('create', [UserObserverController::class, 'createUser']);
Route::post('pay-adapter/{payment_method}/{amount}', [PaymentAdapterController::class, 'processPayment']);
Route::post('pay', [OrderStrategyController::class, 'pay']);
Route::post('send-notification/{type}/{to}', [NotificationController::class, 'send']);
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store'])->can('create', 'product');
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}/update', [ProductController::class, 'update']);
Route::delete('/products/{id}/delete', [ProductController::class, 'delete'])->can('delete', 'product');
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
    Route::post('/cart/add', [ApiCartController::class, 'addToCart']);
    Route::get('/cart/view', [ApiCartController::class, 'viewCart']);
    Route::PATCH('/cart-item/update/{id}', [ApiCartController::class, 'updateCartItem']);
    Route::delete('/cart/remove/{id}', [ApiCartController::class, 'removeCartItem']);
    Route::delete('/cart/clear', [ApiCartController::class, 'clearCart']);
    Route::post('/cart/apply-coupon', [ApiCartController::class, 'applyCoupon']);
    // Route::get('/shipping-methods', [ShippingMethodController::class, 'index']);
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
    // Route::post('webhook/myfatoorah', [MyFatoorahWebhookController::class, 'handle']);
    Route::post('/payment/status', [PaymentController::class, 'getPaymentStatus']);
});
Route::post('/payment/callback', [PaymentController::class, 'handleCallback']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/addresses/update', [AddressController::class, 'addNewAddress']);
});
Route::get('/orders/users/{user_id}', [OrderController::class, 'ordersByUser']);
Route::get('users/orders/', [OrderController::class, 'ordersByUsers']);
Route::prefix('admins')->group(function () {
    Route::post('/login', [JwtAdminAuthController::class, 'login']);
});
Route::middleware('auth:api-admin')->get('/logout', [JwtAdminAuthController::class, 'logout']);
/*----------------------------------------------------------------*/
Route::middleware('auth:api-admin')->apiResource('roles', RoleController::class);
Route::middleware('auth:api-admin')->apiResource('permissions', PermissionController::class);
/*----------------------------------------------------------------*/



Route::post('/roles/{role}/permissions/{permission}', [PermissionRoleController::class, 'createPermissionRole']);
Route::prefix('customers')->group(function () {
    Route::post('create', [WebCustomerController::class, 'createOrUpdateCustomer']);
    Route::get('/', [WebCustomerController::class, 'getCustomersUsingCache']);
    Route::post('/createCustomer', [WebCustomerController::class, 'create']);
    Route::post('/createOrUpdateCustomerUsingCache', [WebCustomerController::class, 'createOrUpdateCustomerUsingCache']);
    // Route::post('create', dd(123));
});
Route::resource('customer-orders', CustomerOrderController::class);
Route::get('customer-orders-redis', [CustomerOrderController::class, 'indexRedis'])->middleware('throttle:global');
Route::get('customer-orders-cache', [CustomerOrderController::class, 'indexCache']);


Route::post('/users', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
    ]);

    return response()->json([
        'id' => 1,
        'name' => $data['name'],
        'email' => $data['email'],
    ], 201);
});
