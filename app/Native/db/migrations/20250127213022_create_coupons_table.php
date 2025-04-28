<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCouponsTable extends AbstractMigration
{

    public function change(): void
    {
        // Create the 'coupons' table
        $table = $this->table('coupons');
        if (!$this->hasTable('coupons')) {


            // Add columns to the table
            $table->addColumn('code', 'string', ['limit' => 255])
                ->addColumn('discount_type', 'enum', ['values' => ['fixed', 'percentage']])
                ->addColumn('discount_value', 'decimal', ['precision' => 8, 'scale' => 2])
                ->addColumn('expires_at', 'timestamp', ['null' => true])
                ->addColumn('is_active', 'boolean', ['default' => true])
                ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
                ->changeColumn('id', 'biginteger', ['null' => true])
                ->create();

            // Add a unique index for the 'code' column
            $table->addIndex(['code'], ['unique' => true])->save();
        }
    }
}
