<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un administrateur
        User::create([
            'name' => 'Admin',
            'email' => 'admin@clotheszc.com',
            'password' => Hash::make('admin123'),
            'role' => User::ADMIN_ROLE,
        ]);

        // Créer un utilisateur standard
        User::create([
            'name' => 'Client Test',
            'email' => 'client@clotheszc.com',
            'password' => Hash::make('client123'),
            'role' => User::USER_ROLE,
        ]);

        // Créer quelques autres utilisateurs
        User::create([
            'name' => 'Marie Dupont',
            'email' => 'marie@example.com',
            'password' => Hash::make('password'),
            'role' => User::USER_ROLE,
        ]);

        User::create([
            'name' => 'Jean Martin',
            'email' => 'jean@example.com',
            'password' => Hash::make('password'),
            'role' => User::USER_ROLE,
        ]);
    }
}
