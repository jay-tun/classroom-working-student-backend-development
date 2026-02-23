<?php

declare(strict_types=1);

namespace App;

use App\Interfaces\Resettable;
use App\Traits\CanLogin;
use RuntimeException;

class AdminUser extends UserBase implements Resettable
{
    use CanLogin;

    private ?string $password = null;

    public function getRole(): string
    {
        return self::ROLE_ADMIN;
    }

    public function resetPassword(): void
    {
        if ($this->email === '') {
            throw new RuntimeException('Cannot reset password without an email address.');
        }

        // Simple password reset simulation
        $this->password = bin2hex(random_bytes(8));

        // In a real system, this would trigger an email
        echo "Password reset for {$this->email}. New temporary password generated.\n";
    }

    // Only to test if resetPassword worked, not used in real systems
    public function getPassword(): ?string
    {
        return $this->password;
    }
}
