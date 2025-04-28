<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateShippingMethodsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * This method contains the reversible migrations.
     */
    public function change(): void
    {
        // Create the shipping_methods table
        $table = $this->table('shipping_methods');

        $table->addColumn('name', 'string') // Shipping method name
            ->changeColumn('id', 'bigint', ['null' => true])

            ->addColumn('cost', 'decimal', ['precision' => 8, 'scale' => 2]) // Shipping cost
            ->addColumn('delivery_time', 'integer', ['null' => true]) // Delivery time in days
            ->addColumn('description', 'string', ['null' => true]) // Description
            ->addColumn('image', 'string', ['null' => true]) // Image
            ->addColumn('slug', 'string') // Slug for SEO
            ->addColumn('is_default', 'boolean', ['default' => false]) // Default shipping method
            ->addColumn('is_free', 'boolean', ['default' => false]) // Free shipping
            ->addColumn('is_pickup', 'boolean', ['default' => false]) // Pickup option
            ->addColumn('is_active', 'boolean', ['default' => true]) // Active status
            ->addTimestamps() // Created and updated timestamps
            ->create();
    }
}
