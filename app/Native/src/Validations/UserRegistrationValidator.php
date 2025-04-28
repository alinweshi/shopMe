<?php

namespace App\Validations;

use App\Interfaces\RegistrationValidatorInterface;

// Concrete implementation
class UserRegistrationValidator implements RegistrationValidatorInterface

{
    public $emailValidator;
    public function __construct()
    {
        $this->emailValidator = new EmailValidator();
    }

    public function validate(array $data): array
    {
        $errors = [];

        if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['password'])) {
            $errors[] = "All fields are required.";
        }
        $validatedEmail = $this->emailValidator->validate($data['email']);
        if (!$validatedEmail) {
            $errors[] = "Invalid email format.";
        }
        // if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        //     $errors[] = "Invalid email format.";
        // }

        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = "Passwords do not match.";
        }

        return $errors;
    }
}
