<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateCartsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your migrations using this method.
     */
    public function change(): void
    {
        $table = $this->table('carts');
        if (!$this->hasTable('carts')) {


            // Adding columns to the 'carts' table
            $table->addColumn('user_id', 'biginteger', ['null' => true]) // User ID
                ->changeColumn('id', 'bigint', ['null' => true])

                ->addColumn('session_id', 'string', ['null' => true]) // Session ID for guests
                ->addColumn('coupon_id', 'biginteger', ['null' => true]) // Link to coupons table
                ->addColumn('total_price', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0.00]) // Total price for the cart
                ->addColumn('cart_expiry', 'timestamp', ['null' => true]) // Expiry date for the cart
                ->addColumn('status', 'enum', ['values' => ['active', 'abandoned', 'completed'], 'default' => 'active']) // Cart status
                ->addColumn('user_agent', 'string', ['null' => true]) // User agent for tracking browser details
                ->addColumn('ip_address', 'string', ['null' => true]) // IP address for tracking user
                ->addTimestamps(); // Created and updated timestamps

            // Adding foreign key constraint to coupon_id column
            $table->addForeignKey('coupon_id', 'coupons', 'id', ['delete' => 'SET_NULL', 'update' => 'NO_ACTION']);

            $table->create(); // Creating the table
        }
    }
}
