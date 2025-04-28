<?php

namespace App\DesignPatterns\Behavioural\Observer\User;

class SmsObserver implements \SplObserver
{
    public function update(\SplSubject $subject): void
    {
        echo "SMS class has been notified!\n";
    }
}
