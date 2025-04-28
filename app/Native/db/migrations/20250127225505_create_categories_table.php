<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateCategoriesTable extends AbstractMigration
{
    public function change()
    {
        // Create the categories table
        $table = $this->table('categories');
        if (!$this->hasTable('categories')) {

            $table->addColumn('name', 'string')
                ->changeColumn('id', 'biginteger', ['null' => true])

                ->addColumn('slug', 'string')
                ->addColumn('description', 'text', ['null' => true])
                ->addColumn('parent_id', 'biginteger', ['null' => true])
                ->addColumn('image', 'string')
                ->addTimestamps()
                ->addIndex(['parent_id']) // Index for parent_id
                ->addForeignKey('parent_id', 'categories', 'id', ['delete' => 'SET_NULL', 'update' => 'NO_ACTION'])
                ->create();
        }
    }
}
