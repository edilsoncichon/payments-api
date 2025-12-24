<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Enum\UserType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $uuid
 * @property int $wallet_id
 * @property UserType $type
 * @property string $full_name
 * @property string $document
 * @property string $email
 * @property string $password
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Wallet $wallet
 */
class User extends Model
{
    use HasFactory;

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
