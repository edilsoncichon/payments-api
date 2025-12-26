<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Transaction\Exception\TransactionUpdateNotAllowedException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $uuid
 * @property int $payer_wallet_id
 * @property int $payee_wallet_id
 * @property int $value
 * @property Carbon $created_at
 * @property Wallet $payerWallet
 * @property Wallet $payeeWallet
 */
class Transaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function payerWallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'id', 'payer_wallet_id');
    }

    public function payeeWallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'id', 'payee_wallet_id');
    }

    /**
     * @throws TransactionUpdateNotAllowedException
     */
    public function update(array $attributes = [], array $options = [])
    {
        throw new TransactionUpdateNotAllowedException('Transactions cannot be updated once created.');
    }
}
