<?php

namespace App\Controllers;

use App\Models\User;
use App\Validations\EmailValidator;
use App\Validations\UserRegistrationValidator;

class UserAuthController
{
    public $emailValidator;
    public function __construct()
    {
        $this->emailValidator = new EmailValidator();
    }
    public function showLoginForm()
    {
        include __DIR__ . '/../Views/login.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? null;
            $inputPassword = $_POST['password'] ?? null;

            // Validate email and password presence
            if (!$email || !$inputPassword) {
                echo "Email and password are required.";
                exit;
            }
            // $password = password_hash($password, PASSWORD_DEFAULT);

            // Sanitize and validate email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format.";
                exit;
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            var_dump($user);
            if ($user && password_verify($inputPassword,  $user['password'])) {
                echo "Login successful.";
                // Successful login - Start session
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];

                header('Location: /home');
                exit;
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "Invalid request method.";
        }
    }
    public function showRegisterForm()
    {
        include __DIR__ . '/../Views/register.php';
    }
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $image = $_FILES['image'] ?? null;
            $validator = new UserRegistrationValidator();
            $errors = $validator->validate($_POST);

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo $error . '<br>';
                }
            }

            // Check if user already exists
            $userModel = new User();
            if ($userModel->findByEmail($email)) {
                echo "Email already registered.";
                return;
            }

            // Move uploaded image (ensure `uploads` directory exists)
            $imagePath = 'uploads/' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], __DIR__ . '/../public/' . $imagePath);

            // Create user
            $isCreated = $userModel->createUser($firstName, $lastName, $email, $password, $imagePath);

            if ($isCreated) {
                header('Location: /login');
                exit;
            } else {
                echo "Registration failed. Please try again.";
            }
        }
    }
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
