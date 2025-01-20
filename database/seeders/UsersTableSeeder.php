<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name' => 'ali',
            'last_name' => 'mohamed',
            'email' => 'alinweshi@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '01091092848',
            'image' => 'uploads/1.jpg'
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
