<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer ou mettre à jour le compte administrateur
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Créer ou mettre à jour le compte client
        User::updateOrCreate(
            ['email' => 'client@test.com'],
            [
                'name' => 'Client Test',
                'password' => Hash::make('client123'),
                'role' => 'user',
            ]
        );
    }
}
