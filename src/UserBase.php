<?php declare(strict_types=1);

namespace App;

use InvalidArgumentException;

// Abstract base for all users.
abstract class UserBase
{
    // To be implemented by candidates.
    public const ROLE_ADMIN = 'admin';
    public const ROLE_CUSTOMER = 'customer';

    protected static int $userCount = 0;

    protected string $name;
    protected string $email;

    public function __construct(string $name, string $email)
    {
        $this->setEmail($email);
        $this->name = $name;

        self::$userCount++;
    }

    public static function getUserCount(): int
    {
        return self::$userCount;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    protected function setEmail(string $email): void
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid E-mail address!');
        }

        $this->email = $email;
    }

    public function __toString(): string
    {
        return sprintf('%s <%s>', $this->name, $this->email);
    }

    public function __get(string $property)
    {
        return $this->$property ?? null;
    }

    public function __set(string $property, $value): void
    {
        $this->$property = $value;
    }

    abstract public function getRole(): string;
}