<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateVendorsTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change(): void
    {
        // Create the vendors table
        $table = $this->table('vendors', ['id' => 'biginteger', 'signed' => false, 'identity' => true]);

        // Add columns
        $table->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 255, 'null' => false])
            ->addIndex(['email'], ['unique' => true]) // Unique index for email
            ->addColumn('phone', 'string', ['limit' => 255, 'null' => true]) // Nullable phone
            ->addColumn('address', 'text', ['null' => true]) // Nullable address
            ->addTimestamps(); // Created_at and updated_at timestamps

        // Create the table
        $table->create();
    }
}
