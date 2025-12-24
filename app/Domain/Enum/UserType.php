<?php

namespace App\Domain\Enum;

enum UserType: string
{
    case COMMON = 'common';
    case MERCHANT = 'merchant';
}
