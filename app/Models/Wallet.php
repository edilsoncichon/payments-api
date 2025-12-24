<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $uuid
 * @property int $balance
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $owner
 */
class Wallet extends Model
{
    use HasFactory;

    public function owner(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
