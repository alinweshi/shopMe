<?php

namespace App\DesignPatterns\Behavioural\Observer\User;

use SplSubject;
use SplObserver;
use App\Models\User;

class UserRepository implements SplSubject //subject
{
    private array $users = [];
    private \SplObjectStorage $observers;
    private static $instance;
    private function __construct()
    {
        $this->observers = new \SplObjectStorage(); //php built in class that stores objects set of objects that implement SplObserver interface for storing observers
    }
    public function add(User $user): void
    {
        $this->users[] = $user;
        $this->notify();
    }
    public static function getInstance(): UserRepository
    {
        if (!isset(self::$instance)) {
            self::$instance = new UserRepository();
        }
        return self::$instance;
    }
    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }
    public function detach(\SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }
    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}
