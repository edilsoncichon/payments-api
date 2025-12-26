<?php

declare(strict_types=1);

namespace App\Domain\Wallet\Entities;

use App\Domain\Wallet\Exceptions\InsufficientFundsException;

final class Wallet
{
    private int $id;
    private int $balance;
    private int $userId;

    public function __construct(int $id, int $userId, int $balance)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->balance = $balance;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @throws InsufficientFundsException
     */
    public function debit(int $amount): void
    {
        if ($amount > $this->balance) {
            throw new InsufficientFundsException();
        }
        $this->balance -= $amount;
    }

    public function credit(int $amount): void
    {
        $this->balance += $amount;
    }
}
