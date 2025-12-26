<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entities;

use App\Domain\Wallet\Entities\Wallet;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class Transaction
{
    private ?int $id;
    private string $uuid;
    private Wallet $payerWallet;
    private Wallet $payeeWallet;
    private int $amount;
    private DateTimeImmutable $createdAt;

    public function __construct(?int $id,
                                ?string $uuid,
                                Wallet $payerWallet,
                                Wallet $payeeWallet,
                                int $amount,
                                DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->uuid = $uuid ?: Uuid::uuid4()->toString();
        $this->payerWallet = $payerWallet;
        $this->payeeWallet = $payeeWallet;
        $this->amount = $amount;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getPayerWallet(): Wallet
    {
        return $this->payerWallet;
    }

    public function getPayeeWallet(): Wallet
    {
        return $this->payeeWallet;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
