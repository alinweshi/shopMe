<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateCouponUserTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change(): void
    {
        // Create the coupon_user table

        $table = $this->table('coupon_user', ['id' => 'biginteger']);
        if (!$this->hasTable('coupon_user')) {

            // Add columns
            $table->addColumn('coupon_id', 'biginteger', ['null' => false]) // Foreign key to coupons
                ->addColumn('user_id', 'biginteger', ['null' => false])   // Foreign key to users
                ->addColumn('used_at', 'timestamp', ['null' => true])    // Timestamp for when the coupon was used

                // Add foreign key constraints
                ->addForeignKey('coupon_id', 'coupons', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
                ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);

            // Create the table
            $table->create();
        }
    }
}
