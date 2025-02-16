<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function create(User $user, Product $product)
    {
        // Only the owner of the product can create it
        return $user->id === $product->user_id
            ? Response::allow()
            : Response::deny('You cannot update.');
    }
    public function update(User $user, Product $product)
    {
        // Only the owner of the product can update it
        return $user->isAdmin()
            // return $user->role=='writer'
            ? Response::allow()
            : Response::deny('You cannot update.');
    }
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return null;
    }
}
