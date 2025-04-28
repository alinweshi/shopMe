<?php

use App\Models\User;
use App\Livewire\Task;
use App\Livewire\Todo;
use App\Livewire\Index;
use App\Models\Message;
use App\Livewire\Checkout;
use App\Livewire\TodoList;
use App\Livewire\TaskComponent;
use App\Livewire\IndexComponent;
use App\Livewire\ShowUserComponent;
use App\Livewire\UsersListComponent;
use Illuminate\Support\Facades\Auth;
use App\Livewire\UpdateUserComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WebCustomerController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\Broadcast\ChatController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\WebControllers\User\LoginUserController;
use App\Http\Controllers\WebControllers\User\RegisteredUserController;

Route::get('/main', function () {
    return view('home');
})->name('main');
/*------------------------------------------------------------------------------*/
Route::get('test-findOrFalse/{id}', function () {
    // dd(1);
    // dd(User::findOrFalse(request('id')));
});
/*------------------------------------------------------------------------------*/
Route::get(
    'test-str-macro',
    function () {
        dd(Str::strCount('hello world,my name is ali'));
    }
);
/*------------------------------------------------------------------------------*/
Route::get(
    'test-arr-macro',
    function () {
        dd(Arr::doubleArray([1, 2, 3, 4, 5, 6, 7]));
    }
);
/*------------------------------------------------------------------------------*/

// Registration Routes
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');


Route::post('/logout', [LoginUserController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/login', [LoginUserController::class, 'create'])->name('login');
Route::post('/login', [LoginUserController::class, 'login']);

//Forgot Password Routes
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

// // Reset Password Routes
// Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
// Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
Route::get('chat-users', [ChatController::class, 'index']);

Route::get('chat/{receiverId}', [ChatController::class, 'chat'])->name('chat');
// Route::get('chat/{receiverId}',  function($receiverId)
//     {
//         dd(Auth::id());
//         // Fetch messages for the chat
//         $messages = Message::where(
//             function ($query)  use ($receiverId) {
//                 $query->where('sender_id', Auth::id())
//                     ->Where('receiver_id', $receiverId);
//             }
//         )->orWhere(
//             function ($query) use ($receiverId) {
//                 $query->where('sender_id', $receiverId)
//                     ->Where('receiver_id', Auth::id());
//             }
//         )->get();

//         // dd($messages);
//         // dd($messages);
//         return view('chats.chat', compact(['messages', 'receiverId']));
//     })->name('chat');
Route::post('send-message/{receiverId}', [ChatController::class, 'sendMessage'])->name('sendMessage');
Route::post('/typing', [ChatController::class, 'typing']);
Route::post('online', [ChatController::class, 'online']);
Route::post('offline', [ChatController::class, 'offline']);



Route::get('/', function () {
    return view('welcome');
});
Route::get('index', action: IndexComponent::class)->name('index');

// Route::middleware('auth')->group(callback: function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
Route::get('/home', [ProductController::class, 'index'])->name('home');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'removeCartItem'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
// Route::get('products', [ProductController::class, 'index'])->name('products.index');
// route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
// Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');


// Group routes related to orders
Route::prefix('orders')->name('orders.')->group(function () {
    // Route to create a new order
    Route::post('/create', [OrderController::class, 'createOrder'])->name('create');

    // Route to view all orders (for admin or user)
    Route::get('/', [OrderController::class, 'index'])->name('index');

    // Route to view a specific order
    Route::get('/{orderId}', [OrderController::class, 'show'])->name('show');

    // Route to update the status of an order
    Route::put('/{orderId}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');

    // Route for order confirmation page
    Route::get('/confirmation/{orderId}', [OrderController::class, 'confirmation'])->name('confirmation');
    Route::get('/{orderId}/edit', [OrderController::class, 'edit'])->name('edit');
});
// route::get('/todo',action: Task::class)->name('todo.home');
// routes/web.php




// Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
// Route::get('/payment/error', [PaymentController::class, 'error'])->name('payment.error');
// Route::post('/checkout/initiate-payment', [CheckoutController::class, 'initiatePayment'])->name('checkout.initiatePayment');
// Route::post('/payment/execute', [CheckoutController::class, 'executePayment'])->name('payment.execute');
// Route::get('/checkout', action: Checkout::class)->name('checkout.index'); // Named checkout.index
// Route::get('/payment/redirect', function () {
//     return redirect()->to(request()->get('payment_url')); // Redirect to payment URL
// })->name('payment.redirect');
// Route::get('App',function(){
//     return view('livewire.layouts.Apps');
// });
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
Route::post('/checkout/proceed-to-payment', [CheckoutController::class, 'proceedToPayment'])->name('checkout.proceedToPayment');
Route::get('/checkout/payment-success', [CheckoutController::class, 'paymentSuccess'])->name('checkout.paymentSuccess');
Route::get('/checkout/payment-error', [CheckoutController::class, 'paymentError'])->name('checkout.paymentError');

Route::get('index', action: IndexComponent::class)->name(name: 'index');
require __DIR__ . '/admin.php';
Route::get('task', action: TaskComponent::class)->name('task');
route::get('layout', function () {
    return view('layout.app');
});
Route::get('users/{user}', ShowUserComponent::class)->name('user');
Route::get('users/{user}/update', UpdateUserComponent::class)->name('user.update');
route::get('users', UsersListComponent::class)->name('users');
/*----------------------------------------------------------------*/
/*----------------------------Customer----------------------------*/
// Route::resource('customer-orders', CustomerOrderController::class)->only('index');
