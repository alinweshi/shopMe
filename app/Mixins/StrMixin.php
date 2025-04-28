<?php

namespace App\Mixins;

class StrMixin
{
    public function strCount()
    {
        return function ($string) {
            return str_word_count($string);
        };
    }
}
