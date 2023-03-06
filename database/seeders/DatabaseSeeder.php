<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Employee::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
        ]);
    }
}
