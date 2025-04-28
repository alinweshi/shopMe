<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateOrdersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('orders');
        if (!$this->hasTable('orders')) {
            // Adding columns to the 'orders' table
            $table->addColumn('user_id', 'biginteger', ['null' => true])
                ->changeColumn('id', 'biginteger', ['null' => true])

                ->addColumn('invoice_number', 'string', ['default' => ''])
                ->addColumn('shipping_method_id', 'biginteger')
                ->addColumn('total_price', 'decimal', ['precision' => 10, 'scale' => 2])
                ->addColumn('tax_amount', 'decimal', ['precision' => 8, 'scale' => 2, 'null' => true])
                ->addColumn('total_with_tax', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => true])
                ->addColumn('discount', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0])
                ->addColumn('coupon_code', 'string', ['null' => true])
                ->addColumn('coupon_type', 'enum', ['values' => ['percentage', 'fixed'], 'null' => true])
                ->addColumn('coupon_value', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => true])
                ->addColumn('status', 'enum', ['values' => ['pending', 'processing', 'completed', 'canceled', 'refunded', 'failed'], 'default' => 'pending'])
                ->addColumn('payment_method', 'string', ['null' => true])
                ->addColumn('payment_date', 'timestamp', ['null' => true])
                ->addColumn('shipped_date', 'timestamp', ['null' => true])
                ->addColumn('delivered_date', 'timestamp', ['null' => true])
                ->addColumn('tracking_number', 'string', ['null' => true])
                ->addColumn('shipping_address', 'string', ['null' => true])
                ->addColumn('billing_address', 'string', ['null' => true])
                ->addColumn('order_date', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                ->addTimestamps();

            // Adding foreign key constraints
            $table->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);
            $table->addForeignKey('shipping_method_id', 'shipping_methods', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);

            // Create the table
            $table->create();
        }
    }
}
