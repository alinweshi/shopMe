<?php

namespace App\Events;

class TransactionsStatusChanged
{
    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
