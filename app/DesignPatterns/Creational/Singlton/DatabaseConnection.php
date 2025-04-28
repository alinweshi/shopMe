<?php

namespace App\DesignPatterns\Creational\Singlton;

use PDO;

class DatabaseConnection
{
    private static $instance = null;
    private $connection;
    private function __clone() {}  // Prevent cloning the object
    private function __wakeup() {}  // Prevent unserializing the object  // Avoid creating multiple instances of the class by using the getInstance method instead of creating new objects directly.

    private function __construct()
    {
        $this->connection = new PDO('mysql:host=localhost;dbname=e-ommerce', 'root', '');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->exec('SET NAMES utf8');
        $this->connection->exec('SET CHARACTER SET utf8mb4');
    }
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getConnection()
    {
        return $this->connection;
    }
}
