<?php

namespace App\Validations;

use App\Interfaces\EmailValidatorInterface;

class EmailValidator implements EmailValidatorInterface
{
    public function validate(string $email): bool
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
