<?php

namespace App\DesignPatterns\Behavioural\Observer\User;

class SlackObserver implements \SplObserver
{
    public function update(\SplSubject $subject): void
    {
        echo "Slack class has been notified!\n";
    }
}
