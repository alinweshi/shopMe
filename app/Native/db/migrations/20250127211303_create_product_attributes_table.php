<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

final class CreateProductAttributesTable extends AbstractMigration
{
    public function change(): void
    {
        if (!$this->hasTable('product_attributes')) {

            // Create the 'product_attributes' table
            $table = $this->table('product_attributes', ['id' => 'id']); // Default id is auto-incrementing primary key

            $table->addColumn('product_id', 'integer') // Foreign key to 'products' table
                ->changeColumn('id', 'bigint', ['null' => true])

                ->addColumn('sku', 'string', ['limit' => 255]) // SKU column
                ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2]) // Price column
                ->addColumn('stock', 'integer') // Stock column
                ->addColumn('attribute_id', 'integer') // Foreign key to 'attributes' table
                ->addColumn('attribute_value_id', 'integer') // Foreign key to 'attribute_values' table
                ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP']) // Created timestamp
                ->addColumn('updated', 'datetime', ['null' => true]) // Updated timestamp
                ->addIndex(['sku'], ['unique' => true]) // Unique index for SKU
                ->addForeignKey('product_id', 'products', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']) // FK to 'products'
                ->addForeignKey('attribute_id', 'attributes', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']) // FK to 'attributes'
                ->addForeignKey('attribute_value_id', 'attribute_values', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']) // FK to 'attribute_values'
                ->create();
        }
    }
}
