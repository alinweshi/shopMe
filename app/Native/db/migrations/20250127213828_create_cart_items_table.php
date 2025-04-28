<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateCartItemsTable extends AbstractMigration
{
    public function change(): void
    {

        $table = $this->table('cart_items');
        if (!$this->hasTable('cart_items')) {


            // Adding columns to the 'cart_items' table
            $table->addColumn('cart_id', 'biginteger')
                ->changeColumn('id', 'bigint', ['null' => true])

                ->addColumn('product_id', 'biginteger')
                ->addColumn('product_attribute_id', 'biginteger', ['null' => true])
                ->addColumn('quantity', 'integer', ['default' => 1])
                ->addColumn('original_price', 'decimal', ['precision' => 8, 'scale' => 2, 'null' => true])
                ->addColumn('item_discount', 'decimal', ['precision' => 8, 'scale' => 2, 'null' => true])
                ->addColumn('final_price', 'decimal', ['precision' => 8, 'scale' => 2])
                ->addTimestamps()
                ->addIndex(['cart_id', 'product_id'], ['unique' => true]); // Unique constraint on cart_id and product_id

            // Adding foreign key constraints
            $table->addForeignKey('cart_id', 'carts', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);
            $table->addForeignKey('product_id', 'products', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);
            $table->addForeignKey('product_attribute_id', 'product_attributes', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);

            // Create the table
            $table->create();
        }
    }
}
