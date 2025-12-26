<?php

namespace App\Domain\Wallet\Repositories;

use App\Domain\Wallet\Entities\Wallet;

interface WalletRepository
{
    public function findById(int $id): ?Wallet;

    public function findByUuid(string $uuid): ?Wallet;

    public function updateBalance(Wallet $wallet): void;
}
