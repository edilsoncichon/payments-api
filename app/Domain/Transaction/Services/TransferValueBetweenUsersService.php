<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Services;

use App\Domain\Support\Exceptions\DomainException;
use App\Domain\Transaction\Entities\Transaction;
use App\Domain\Transaction\Repositories\TransactionRepository;
use App\Domain\User\Entities\User;
use App\Domain\User\Enum\UserType;
use App\Domain\User\Repositories\UserRepository;
use App\Domain\Wallet\Exceptions\InsufficientFundsException;
use App\Domain\Wallet\Repositories\WalletRepository;
use DateTimeImmutable;

final class TransferValueBetweenUsersService
{
    private ?User $payer;
    private ?User $payee;

    public function __construct(private TransactionRepository $transactionRepository,
                                private UserRepository        $userRepository,
                                private WalletRepository      $walletRepository)
    {
    }

    /**
     * @throws InsufficientFundsException
     * @throws DomainException
     */
    public function process(string $payerUuid, string $payeeUuid, int $amount): Transaction
    {
        $this->retrieveAndValidateInputs($payerUuid, $payeeUuid, $amount);

        $payerWallet = $this->payer->getWallet();
        $payeeWallet = $this->payee->getWallet();

        $payerWallet->debit($amount);
        $payeeWallet->credit($amount);

        $transaction = new Transaction(
            id: null,
            uuid: null,
            payerWallet: $payerWallet,
            payeeWallet: $payeeWallet,
            amount: $amount,
            createdAt: new DateTimeImmutable()
        );

        $this->transactionRepository->create($transaction);
        $this->walletRepository->updateBalance($payerWallet);
        $this->walletRepository->updateBalance($payeeWallet);

        return $transaction;
    }

    /**
     * @throws DomainException
     */
    private function retrieveAndValidateInputs(string $payerUuid, string $payeeUuid, int $amount): void
    {
        if ($amount <= 0) {
            throw new DomainException('Transfer amount must be greater than zero.');
        }

        if ($payerUuid === $payeeUuid) {
            throw new DomainException('Payer and payee cannot be the same user.');
        }

        $this->payer = $this->userRepository->findByUuid($payerUuid);
        $this->payee = $this->userRepository->findByUuid($payeeUuid);

        if (!$this->payer || !$this->payee) {
            throw new DomainException('Payer or payee not found.');
        }
        if ($this->payer->getType() == UserType::STORE) {
            throw new DomainException('Stores cannot initiate transfers.');
        }
    }
}
