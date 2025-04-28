<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    private static $instance = null;



    public static function getInstance()
    {
        if (!self::$instance) {
            // Load environment variables
            $envPath = __DIR__ . '/../../.env';

            if (!file_exists($envPath)) {
                die("Error: .env file not found at $envPath");
            }

            $dotenv = parse_ini_file($envPath);

            if (!$dotenv) {
                die("Error: Failed to parse .env file.");
            }

            // Ensure required variables are set
            if (empty($dotenv['DB_HOST']) || empty($dotenv['DB_USER']) || empty($dotenv['DB_NAME'])) {
                die("Error: Missing database credentials in .env file.");
            }

            try {
                self::$instance = new PDO(
                    "mysql:host={$dotenv['DB_HOST']};port={$dotenv['DB_PORT']};dbname={$dotenv['DB_NAME']}",
                    $dotenv['DB_USER'],
                    $dotenv['DB_PASS']
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
