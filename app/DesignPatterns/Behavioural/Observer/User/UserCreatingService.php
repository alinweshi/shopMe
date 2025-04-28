<?php

namespace App\DesignPatterns\Behavioural\Observer\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserCreatingService
{
    public function create(User $user): void
    {
        $userRepository = UserRepository::getInstance();
        $userRepository->attach(new EmailObserver());
        $userRepository->attach(new SmsObserver());
        $userRepository->attach(new SlackObserver());
        $userRepository->add($user);
    }
}
