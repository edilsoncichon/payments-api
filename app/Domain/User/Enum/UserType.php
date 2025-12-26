<?php

namespace App\Domain\User\Enum;

enum UserType: string
{
    case COMMON = 'common';
    case STORE = 'store';
}
