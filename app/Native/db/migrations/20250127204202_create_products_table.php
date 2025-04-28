<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProductsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        // Create the 'products' table
        $table = $this->table('products');
        if (!$this->hasTable('products')) {
            // Add columns to the table
            $table->addColumn('name', 'string', ['limit' => 255])
                ->changeColumn('id', 'biginteger', ['null' => true])

                ->addColumn('price', 'decimal', ['precision' => 8, 'scale' => 2])
                ->addColumn('slug', 'string', ['limit' => 255])
                ->addColumn('category_id', 'integer')
                ->addColumn('description', 'text', ['null' => true])
                ->addColumn('brand', 'string', ['limit' => 255, 'null' => true])
                ->addColumn('image', 'string', ['limit' => 255, 'null' => true])
                ->addColumn('stock', 'integer')
                ->addColumn('discount', 'decimal', ['precision' => 8, 'scale' => 2, 'null' => true])
                ->addColumn('discount_type', 'string', ['limit' => 50, 'null' => true])
                ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP']);

            // Add a foreign key constraint
            $table->addForeignKey('category_id', 'categories', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION'
            ]);

            // Create the table
            $table->create();
        }
    }
}
