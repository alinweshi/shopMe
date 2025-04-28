<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateAttributeValuesTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('attribute_values');
        $table->addColumn('attribute_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('attribute_value', 'string', ['limit' => 255, 'null' => false])
            ->addTimestamps()
            ->addForeignKey(
                'attribute_id',     // Column in this table
                'attributes',       // Parent table
                'id',               // Referenced column
                ['delete' => 'CASCADE', 'update' => 'NO_ACTION'] // Constraints
            )
            ->create();
    }
}
