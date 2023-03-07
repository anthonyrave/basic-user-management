<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    /**
     * @return array<string>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
