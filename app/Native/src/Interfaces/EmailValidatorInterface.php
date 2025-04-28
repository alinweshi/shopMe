<?php

namespace App\Interfaces;

interface EmailValidatorInterface
{
    public function validate(string $email): bool;
}
