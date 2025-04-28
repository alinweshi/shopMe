<?php

namespace App\DesignPatterns\Creational\Singlton;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct(private DatabaseConnection $dbConnection)
    {
        $this->dbConnection = DatabaseConnection::getInstance();
    }
    public function index()
    {
        $stmt = $this->dbConnection->getConnection()->prepare("SELECT * FROM users");
        $stmt->execute();
        $users = $stmt->fetchAll();
        dd($users);
        return view('users', compact('users'));
    }
}
