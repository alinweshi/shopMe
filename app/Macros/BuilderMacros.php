<?php

namespace App\Macros;

use Illuminate\Database\Eloquent\Builder;

class BuilderMacros
{
    public function findOrFalse()
    {
        return function ($id, $columns = ['*']) {
            return  $this->find($id, $columns) ?? false;
        };
    }
}
