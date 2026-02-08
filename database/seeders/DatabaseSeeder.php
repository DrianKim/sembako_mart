<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama' => 'Admin Sembako Mart',
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        User::create([
            'nama' => 'Kasir Sembako Mart',
            'username' => 'kasir',
            'password' => bcrypt('kasir123'),
            'no_hp' => '081234567890',
            'role' => 'kasir',
            'status' => 'aktif',
        ]);

        User::create([
            'nama' => 'Owner Sembako Mart',
            'username' => 'owner',
            'password' => bcrypt('owner123'),
            'role' => 'owner',
            'status' => 'aktif',
        ]);
    }
}
