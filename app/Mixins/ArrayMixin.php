<?php

namespace App\Mixins;

class ArrayMixin
{
    public function doubleArray()
    {
        return function (array $array) {
            return array_map(function ($value) {
                return $value * 2;
            }, $array);
        };
    }
}
