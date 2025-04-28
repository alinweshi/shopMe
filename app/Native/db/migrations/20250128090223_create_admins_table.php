<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateAdminsTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change(): void
    {
        // Create the admins table
        $table = $this->table('admins', ['id' => 'biginteger', 'signed' => false, 'identity' => true]);

        // Add columns
        $table->addColumn('first_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('last_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('username', 'string', ['limit' => 255, 'null' => false])
            ->addIndex(['username'], ['unique' => true]) // Unique index for username

            ->addColumn('email', 'string', ['limit' => 255, 'null' => false])
            ->addIndex(['email'], ['unique' => true]) // Unique index for email

            ->addColumn('password', 'string', ['limit' => 255, 'null' => false])

            ->addColumn('phone', 'string', ['limit' => 255, 'null' => true])
            ->addIndex(['phone'], ['unique' => true]) // Unique index for phone

            ->addColumn('image', 'string', ['limit' => 255, 'null' => true])

            ->addColumn('status', 'enum', ['values' => ['active', 'inactive'], 'default' => 'active']) // Status column

            ->addColumn('is_super', 'boolean', ['default' => false]) // Boolean for super admin

            ->addTimestamps(); // Created_at and updated_at timestamps

        // Create the table
        $table->create();
    }
}
