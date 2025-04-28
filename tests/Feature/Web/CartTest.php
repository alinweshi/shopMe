<?php

namespace Tests\Feature\Web;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    public function test_cart_index_function()
    {
        $this->get('/cart')->assertStatus(200);
    }
    use RefreshDatabase;

    // public function authenticated_user_sees_empty_cart_when_no_cart_exists()
    // {
    //     // /** @var \App\Models\User $user */

    //     $user = User::factory()->create();
    //     // dd($user);
    //     // @phpstan-ignore-next-line

    //     // $this->actingAs($user);


    //     // $this->assertAuthenticated();

    //     $this->assertAuthenticatedAs($user, $guard = null);

    //     $response = $this->get(route('cart.view'));

    //     $response->assertViewIs('front.cart.view');
    // }
    public function test_authenticated_user_sees_empty_cart_when_no_cart_exists()
    {
        // Create a user
        $user = User::factory()->create();
        $products = Product::factory(3)->create();
        // dd($products[0]->id);
        // dd($products[0]->final_price);

        // Act as the authenticated user
        $this->actingAs($user);

        // Make a GET request to the cart view route
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);
            // $cartItems = CartItem::create(
            //     [

            //         'cart_id' => $cart->id,
            //         'product_id' => $products[0]->id,
            //         'quantity' => 1,
            //         'original_price' => $products[0]->final_price,
            //         'final_price' => $products[0]->final_price

            //     ]
            // );
            // $cartItems = CartItem::create([
            //     'cart_id' => $cart->id,
            //     'product_id' => $products[1]->id,
            //     'quantity' => 1,
            //     'original_price' => $products[1]->final_price,
            //     'final_price' => $products[1]->final_price
            // ]);
            // $cartItems = CartItem::create([
            //     'cart_id' => $cart->id,
            //     'product_id' => $products[2]->id,
            //     'quantity' => 1,
            //     'original_price' => $products[2]->final_price,
            //     'final_price' => $products[2]->final_price
            // ]);
        }
        foreach ($products as $product) {
            $cartItems = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'original_price' => $product->final_price,
                'final_price' => $product->final_price
            ]);
        }
        $cartItems = CartItem::where('cart_id', $cart->id)->get();
        $total = $cartItems->sum('final_price');
        // dd($cartItems);
        // dd($cart);
        // $cartItems = CartItem::where('cart_id',  $cart->id)->get();


        $response = $this->get(route('cart.view'));
        // $response->dd();
        // dd($response);
        // Assert the correct view is returned
        // dd($cartItems);
        if ($cartItems->count() == 0) {
            $view = $this->view('front.cart.empty');
        }

        $view = $this->view('front.cart.view', ['cartItems' => $cartItems, 'total' => $total]);
        // $view->assertSee('Taylor');

        $view->assertSee('Product Name');
        $view->assertSee('Quantity');
        $view->assertSee('Price');
        $view->assertSee('Total');
        $view->assertSee('Remove');

        $response->assertViewIs('front.cart.view');

        $response->assertViewHas('cartItems', $cartItems);
        $response->assertViewHas('total');



        // $contents = (string) $this->view('front.cart.view');
        // Additionally, you might want to assert that the cart is empty
        // This would depend on how your view receives cart data
        $response->assertViewHas('cart', null); // or whatever your empty cart state is
    }
}
