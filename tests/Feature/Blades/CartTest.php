<?php

namespace Tests\Feature\Blades;

use Tests\TestCase;

class CartTest extends TestCase
{
    public function test_cart_index_can_be_rendered()
    {
        $view = $this->get('/cart');

        $view->assertStatus(200);
        $view->assertSee('Cart');
        $contents = (string) $this->view('front.cart.view');
        $this->assertStringContainsString('<h2>Your Cart</h2>', $contents);
    }
}
