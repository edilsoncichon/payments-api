<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\User;

interface UserRepository
{
    public function findById(int $id): ?User;

    public function findByUuid(string $uuid): ?User;
}
