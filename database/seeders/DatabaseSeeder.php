<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (RoleEnum::cases() as $roleValue) {
            Role::factory()->create([
                'name' => $roleValue,
            ]);
        }

        User::factory()
            ->hasAttached(Role::where('name', RoleEnum::ADMIN)->first())
            ->create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin'),
                'deleted' => false,
                'deleted_at' => null,
            ]);

        User::factory()
            ->count(5)
            ->hasAttached(Role::where('name', RoleEnum::DEFAULT)->first())
            ->create();
    }
}
