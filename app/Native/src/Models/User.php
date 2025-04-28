<?php

declare(strict_types=1);

namespace App\Models;


use App\Database\Connection;
use PDO;
use PDOException;

class User
{
    private $db;
    public $user;

    public function __construct()
    {
        $this->db = Connection::getInstance();
        $this->user = null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function createUser(string $firstName, string $lastName, string $email, string $password, string $image): bool
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare(
                "INSERT INTO users (first_name, last_name, email, password, image) 
                 VALUES (:first_name, :last_name, :email, :password, :image)"
            );

            return $stmt->execute([
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'email'      => $email,
                'password'   => $hashedPassword,
                'image'      => $image
            ]);
        } catch (PDOException $e) {
            error_log("User creation failed: " . $e->getMessage());
            return false;
        }
    }
    $user= new User();
    $user->createUser('ali', 'mohamed', 'alinweshi@gmail.com', '12345678', 'uploads/1.jpg');
}
