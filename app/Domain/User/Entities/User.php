<?php

declare(strict_types=1);

namespace App\Domain\User\Entities;

use App\Domain\User\Enum\UserType;
use App\Domain\Wallet\Entities\Wallet;

class User
{
    public function __construct(private int $id,
                                private UserType $type,
                                private string $name,
                                private string $email,
                                private ?Wallet $wallet)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): UserType
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }
}
