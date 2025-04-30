<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'first_name' => 'ali',
            'last_name' => 'mohamed',
            'username' => 'ali',
            'email' => 'alinweshi@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '01091092848',
            'image' => 'uploads/1.jpg',
            'status' => 'active',
            'is_super' => 1
        ]);
        Admin::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin',
            'password' => Hash::make('12345678'),
            'phone' => '01991092848',
            'image' => 'uploads/1.jpg',
            'status' => 'active',
            'is_super' => 0
        ]);

        // User::create([
        //     'first_name' => 'John',
        //     'last_name' => 'Doe',
        //     'email' => 'j1ohndoe@example.com',
        //     'password' => Hash::make('password'),
        //     'phone' => '010097017877',
        //     'image' => 'uploads/1.jpg'
        //         ]);
        // User::create([
        //     'first_name' => 'kamal',
        //     'last_name' => 'kamal',
        //     'email' => 'k1amal@example.com',
        //     'password' => Hash::make('password'),
        //     'phone' => '01097017877',
        //     'image' => 'uploads/1.jpg'

        // ]);

    }
}
