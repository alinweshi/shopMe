<?php

namespace App\DesignPatterns\Behavioural\Observer\User;

use SplSubject;

class EmailObserver implements \SplObserver
{

    public function update(\SplSubject $subject): void
    {
        echo "Email class has been notified!\n";
    }
}
