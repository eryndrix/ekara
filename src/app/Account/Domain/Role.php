<?php declare(strict_types=1);

namespace App\Account\Domain;

enum Role: string
{
    /**
     * Administrator role.
     */
    case Admin = 'admin';

    /**
     * Regular user role.
     */
    case User = 'user';

    /**
     * Guest role.
     */
    case Guest = 'guest';

    /**
     * @phpstan-return string
     */
    public function label(): string
    {
        return match($this) {
            self::Admin => 'Administrator',
            self::User => 'User',
            self::Guest => 'Guest',
        };
    }

    /**
     * @phpstan-return bool
     */
    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }

    /**
     * @phpstan-return bool
     */
    public function isUser(): bool
    {
        return $this === self::User;
    }

    /**
     * @phpstan-return bool
     */
    public function isGuest(): bool
    {
        return $this === self::Guest;
    }
}
