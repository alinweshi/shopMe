<?php

namespace App\DesignPatterns\Behavioural\Observer\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserObserverController extends Controller
{
    public function __construct(public UserCreatingService $userCreatingService) {}
    public function createUser(Request $request)
    {
        $user = User::create($request->all());
        $this->userCreatingService->create($user);
    }
}
