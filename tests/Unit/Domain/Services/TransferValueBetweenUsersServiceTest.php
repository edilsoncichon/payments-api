<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Services;

use App\Domain\Support\Exceptions\DomainException;
use App\Domain\Transaction\Entities\Transaction;
use App\Domain\Transaction\Repositories\TransactionRepository;
use App\Domain\Transaction\Services\TransferValueBetweenUsersService;
use App\Domain\User\Entities\User;
use App\Domain\User\Enum\UserType;
use App\Domain\User\Repositories\UserRepository;
use App\Domain\Wallet\Entities\Wallet;
use App\Domain\Wallet\Exceptions\InsufficientFundsException;
use App\Domain\Wallet\Repositories\WalletRepository;
use Tests\TestCase;

class TransferValueBetweenUsersServiceTest extends TestCase
{
    private TransferValueBetweenUsersService $service;
    private Transaction $transaction;
    private string $payerUuid;
    private string $payeeUuid;
    private Wallet $payerWallet;
    private Wallet $payeeWallet;
    private User $payer;
    private User $payee;

    protected function setUp(): void
    {
        parent::setUp();

        $this->payerUuid = $this->faker->uuid();
        $this->payeeUuid = $this->faker->uuid();

        $this->payerWallet = new Wallet(1, 1, 500);
        $this->payeeWallet = new Wallet(2, 2, 500);
        $this->payer = new User(1, UserType::COMMON, 'Edilson Cichon', 'edilson@mail.com', $this->payerWallet);
        $this->payee = new User(2, UserType::STORE, 'Maria Quintão', 'maria@mail.com', $this->payeeWallet);

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('findByUuid')
            ->willReturnMap([
                [$this->payerUuid, $this->payer],
                [$this->payeeUuid, $this->payee],
            ]);

        $walletRepository = $this->createMock(WalletRepository::class);

        $this->transaction = new Transaction(
            1,
            $this->faker->uuid(),
            $this->payerWallet,
            $this->payeeWallet,
            100,
            new \DateTimeImmutable()
        );

        $transactionRepository = $this->createMock(TransactionRepository::class);
        $transactionRepository->method('create')->willReturn($this->transaction);

        $this->service = new TransferValueBetweenUsersService(
            $transactionRepository,
            $userRepository,
            $walletRepository,
        );
    }

    public function test_should_transfer_value_between_users(): void
    {
        $transaction = $this->service->process($this->payerUuid, $this->payeeUuid, 100);

        $this->assertEquals(400, $this->payerWallet->getBalance());
        $this->assertEquals(600, $this->payeeWallet->getBalance());

        $this->assertEquals($this->payerWallet->getId(), $transaction->getPayerWallet()->getId());
        $this->assertEquals($this->payeeWallet->getId(), $transaction->getPayeeWallet()->getId());
        $this->assertEquals(100, $transaction->getAmount());
    }

    public function test_should_not_transfer_value_when_payer_has_insufficient_funds(): void
    {
        $this->expectException(InsufficientFundsException::class);
        $this->service->process($this->payerUuid, $this->payeeUuid, 600);
    }

    public function test_should_not_allow_store_as_payer()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Stores cannot initiate transfers.');
        $this->service->process($this->payeeUuid, $this->payerUuid, 100);
    }

    public function test_should_not_allow_nonexistent_users()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Payer or payee not found.');
        $this->service->process('nonexistent-payer-uuid', 'nonexistent-payee-uuid', 100);
    }

    public function test_should_not_allow_payer_and_payee_to_be_the_same()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Payer and payee cannot be the same user.');
        $this->service->process($this->payerUuid, $this->payerUuid, 100);
    }

    public function test_should_not_allow_negative_transfer_amount()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Transfer amount must be greater than zero.');

        $this->service->process($this->payerUuid, $this->payeeUuid, -100);
    }

    public function test_should_not_allow_zero_transfer_amount()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Transfer amount must be greater than zero.');

        $this->service->process($this->payerUuid, $this->payeeUuid, 0);
    }
}
