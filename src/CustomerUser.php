<?php declare(strict_types=1);

namespace App;

class CustomerUser extends UserBase
{
    public function getRole(): string
    {
        return self::ROLE_CUSTOMER;
    }
}