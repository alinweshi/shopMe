<?php

namespace App\Macros;

use Illuminate\Support\Collection;

class CollectionMacros
{
    public function toUpper()
    {
        return function () {
            /** @var \Illuminate\Support\Collection $this */
            return $this->map(function ($item) {
                return strtoupper((string)$item);
            });
        };
    }
}
