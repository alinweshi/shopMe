<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Illuminate\Validation\Rules\Password;

class UserForm extends Form
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $password = '';

    public function rules()
    {
        return [
            'first_name' => 'required|min:5|max:50',
            'last_name' => 'required|min:5|max:50',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|size:11|unique:users,phone',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ];
    }
}
