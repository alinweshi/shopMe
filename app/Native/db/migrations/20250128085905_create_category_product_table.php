<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\Column;

final class CreateCategoryProductTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your migrations using this method.
     */
    public function change(): void
    {
        // Check if the table already exists
        if (!$this->hasTable('category_product')) {
            $table = $this->table('category_product', ['id' => false, 'primary_key' => ['product_id', 'category_id']]);

            // Define columns
            $table->changeColumn('id', 'biginteger', ['identity' => true])
                ->addColumn('product_id', 'biginteger')
                ->addColumn('category_id', 'biginteger')
                ->addColumn('deleted_at', 'timestamp', ['null' => true])
                ->addTimestamps();

            // Add foreign key constraints
            $table->addForeignKey('product_id', 'products', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION',
            ])
                ->addForeignKey('category_id', 'categories', 'id', [
                    'delete' => 'CASCADE',
                    'update' => 'NO_ACTION',
                ]);

            // Add unique constraint
            $table->addIndex(['product_id', 'category_id'], ['unique' => true]);

            // Create the table
            $table->create();
        }
    }
}
