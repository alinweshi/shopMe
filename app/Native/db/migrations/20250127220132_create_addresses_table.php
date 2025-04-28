<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateAddressesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your migrations using this method. The methods are
     * documented at: https://docs.phinx.org/en/latest/migrations.html
     */
    public function change()
    {
        $table = $this->table('addresses');
        if (!$this->hasTable('addresses')) {
            $table->addColumn('user_id', 'biginteger')
                ->changeColumn('id', 'bigint', ['null' => true])

                ->addColumn('line1', 'string')
                ->addColumn('line2', 'string', ['null' => true])
                ->addColumn('city', 'string')
                ->addColumn('state', 'string')
                ->addColumn('country', 'string')
                ->addColumn('postal_code', 'string')
                ->addColumn('is_default', 'boolean', ['default' => false])
                ->addTimestamps()
                ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE'])
                ->create();
        }
    }
}
