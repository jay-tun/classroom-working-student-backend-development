<?php declare(strict_types=1);

namespace App\Traits;

trait CanLogin
{
    public function login(): bool
    {   
        // Login simulation
        return true;
    }
}