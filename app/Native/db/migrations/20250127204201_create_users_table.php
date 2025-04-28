<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function change()
    {
        // Create the users table
        $table = $this->table('users');
        if (!$this->hasTable('users')) {
            $table->addColumn('first_name', 'string', ['limit' => 255])
                ->changeColumn('id', 'biginteger', ['null' => true])

                ->addColumn('last_name', 'string', ['limit' => 255])
                ->addColumn('email', 'string', ['limit' => 255])
                ->addColumn('password', 'string', ['limit' => 255])
                ->addColumn('phone', 'string', ['limit' => 20, 'null' => true])
                ->addColumn('image', 'string', ['limit' => 255, 'null' => true])
                ->addColumn('email_verified_at', 'timestamp', ['null' => true])
                ->addColumn('remember_token', 'string', ['limit' => 100, 'null' => true])
                ->addTimestamps()
                ->addIndex(['email'], ['unique' => true]) // Add unique index for email
                ->addIndex(['phone'], ['unique' => true]) // Add unique index for phone
                ->create();

            // Create the password_reset_tokens table
            $this->table('password_reset_tokens')
                ->addColumn('email', 'string', ['limit' => 255])
                ->addColumn('token', 'string', ['limit' => 255])
                ->addColumn('created_at', 'timestamp', ['null' => true])
                ->addIndex(['token'])
                ->changePrimaryKey('email')
                ->create();

            // Create the sessions table
            $this->table('sessions')
                ->addColumn('user_id', 'biginteger', ['null' => true])
                ->addColumn('ip_address', 'string', ['limit' => 45, 'null' => true])
                ->addColumn('user_agent', 'text', ['null' => true])
                ->addColumn('payload', 'longtext')
                ->addColumn('last_activity', 'biginteger')
                ->addIndex(['user_id'])
                ->addIndex(['last_activity'])
                ->changePrimaryKey('id')

                ->create();
        }
    }
}
