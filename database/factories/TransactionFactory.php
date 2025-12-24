<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid()->toString(),
            'payer_wallet_id' => Wallet::factory(),
            'payee_wallet_id' => Wallet::factory(),
            'value' => $this->faker->numberBetween(1, 10000000),
            'created_at' => now(),
        ];
    }
}
