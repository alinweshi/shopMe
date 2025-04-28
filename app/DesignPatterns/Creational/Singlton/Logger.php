<?php

namespace App\DesignPatterns\Creational\Singlton;

class Logger
{
    private static $instance = null;
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Logger();
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function log($message)
    {
        echo "Logging: " . $message . "\n";
    }
}
