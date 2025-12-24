<?php

declare(strict_types=1);

namespace Tests\Integration\Database;

use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class WalletModelTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    public function test_should_create_wallet()
    {
        $model = new Wallet();
        $model->uuid = Str::uuid();
        $model->balance = $this->faker()->numberBetween(0, 9999999999);
        $model->save();

        $this->assertDatabaseHas('wallets', $model->only(['id', 'uuid', 'balance']));
    }

    public function test_should_fill_fields_correctly()
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::factory()->create();

        $this->assertIsInt($wallet->id);
        $this->assertIsString($wallet->uuid);
        $this->assertIsInt($wallet->balance);
        $this->assertTrue($wallet->created_at instanceof Carbon);
        $this->assertTrue($wallet->updated_at instanceof Carbon);
    }

    public function test_should_find_wallet()
    {
        $wallet = Wallet::factory()->create();
        $findResult = Wallet::query()->findOrFail($wallet->id);

        $this->assertTrue($findResult->exists);
    }

    public function test_should_destroy_wallet()
    {
        $wallet = Wallet::factory()->create();
        $wallet->delete();
        $this->assertDatabaseMissing('wallets', ['id' => $wallet->id]);
    }

    public function test_should_be_linked_to_the_user()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $wallet = $user->wallet;
        $this->assertTrue($wallet instanceof Wallet);
        $this->assertTrue($wallet->owner instanceof User);
    }

    public function test_should_not_allow_create_wallet_without_owner()
    {
        $this->expectException(QueryException::class);
        Wallet::factory()->create(['user_id' => null]);
    }
}
