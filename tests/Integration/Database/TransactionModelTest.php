<?php

declare(strict_types=1);

namespace Tests\Integration\Database;

use App\Domain\Transaction\Exception\TransactionUpdateNotAllowedException;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class TransactionModelTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    public function test_should_create_transaction()
    {
        $transaction = new Transaction();
        $transaction->uuid = Str::uuid()->toString();
        $transaction->value = 20.99 * 100;
        $transaction->payer_wallet_id = Wallet::factory()->create()->id;
        $transaction->payee_wallet_id = Wallet::factory()->create()->id;
        $transaction->created_at = now();
        $transaction->save();

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'uuid' => $transaction->uuid,
            'payer_wallet_id' => $transaction->payer_wallet_id,
            'payee_wallet_id' => $transaction->payee_wallet_id,
            'value' => $transaction->value,
        ]);
    }

    public function test_transaction_cannot_be_updated()
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()->create();

        $originalValue = $transaction->value;

        $this->expectException(TransactionUpdateNotAllowedException::class);

        $transaction->value = $originalValue * 2;
        $transaction->update();
    }

    public function test_should_find_transaction()
    {
        $transaction = Transaction::factory()->create();
        $findResult = Transaction::query()->findOrFail($transaction->id);

        $this->assertTrue($findResult->exists);
    }

    public function test_should_destroy_transaction()
    {
        $model = Transaction::factory()->create();
        $model->delete();
        $this->assertDatabaseMissing('transactions', ['id' => $model->id]);
    }

    public function test_should_not_allow_create_transaction_without_payer()
    {
        $this->expectException(QueryException::class);
        Transaction::factory()->create(['payer_wallet_id' => null]);
    }

    public function test_should_not_allow_create_transaction_without_payee()
    {
        $this->expectException(QueryException::class);
        Transaction::factory()->create(['payee_wallet_id' => null]);
    }

    public function test_transaction_wallets_exist_and_are_linked_correctly()
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()->create();

        $payerWallet = Wallet::query()->find($transaction->payer_wallet_id);
        $payeeWallet = Wallet::query()->find($transaction->payee_wallet_id);

        $this->assertNotNull($payerWallet, 'Payer wallet does not exist.');
        $this->assertNotNull($payeeWallet, 'Payee wallet does not exist.');

        $this->assertEquals($transaction->payerWallet->id, $payerWallet->id, 'Payer wallet ID does not match.');
        $this->assertEquals($transaction->payeeWallet->id, $payeeWallet->id, 'Payee wallet ID does not match.');
    }
}
