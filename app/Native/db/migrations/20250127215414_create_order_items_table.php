<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateOrderItemsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('order_items');
        if (!$this->hasTable('order_items')) {

            // Adding columns to the 'order_items' table
            $table->addColumn('order_id', 'biginteger')
                ->changeColumn('id', 'bigint', ['null' => true])

                ->addColumn('product_id', 'biginteger')
                ->addColumn('product_attribute_id', 'biginteger', ['null' => true])
                ->addColumn('quantity', 'integer')
                ->addColumn('unit_price', 'decimal', ['precision' => 10, 'scale' => 2])
                ->addColumn('total_price', 'decimal', ['precision' => 10, 'scale' => 2])
                ->addTimestamps();

            // Adding foreign key constraints
            $table->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);
            $table->addForeignKey('product_id', 'products', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);
            $table->addForeignKey('product_attribute_id', 'product_attributes', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);

            // Create the table
            $table->create();
        }
    }
}
