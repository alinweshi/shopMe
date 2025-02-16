<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    /**
     * Determine if the user can add items to the cart.
     */
    public function addToCart(User $user, Cart $cart)
    {
        // Only the owner of the cart can add items to it
        return $user->id === $cart->user_id;
    }

    /**
     * Determine if the user can view the cart.
     */
    public function viewCart(User $user, Cart $cart)
    {
        // Only the owner of the cart can view it
        return $user->id === $cart->user_id;
    }

    /**
     * Determine if the user can clear the cart.
     */
    public function clearCart(User $user, Cart $cart)
    {
        // Only the owner of the cart can clear it
        return $user->id === $cart->user_id;
    }

    /**
     * Determine if the user can update a cart item.
     */
    public function updateCartItem(User $user, Cart $cart)
    {
        // Only the owner of the cart can update its items
        return $user->id === $cart->user_id;
    }
}
