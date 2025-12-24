<?php

namespace Database\Factories;

use App\Domain\Enum\UserType;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid()->toString(),
            'wallet_id' => Wallet::factory(),
            'type' => UserType::COMMON,
            'full_name' => $this->faker->name(),
            'document' => $this->faker->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ];
    }
}
