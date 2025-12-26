<?php

namespace App\Domain\Transaction\Repositories;

use App\Domain\Transaction\Entities\Transaction;

interface TransactionRepository
{
    public function findById(int $id): ?Transaction;

    public function findByUuid(string $uuid): ?Transaction;

    public function create(Transaction $transaction): Transaction;
}
