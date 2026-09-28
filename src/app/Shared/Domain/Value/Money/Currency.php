<?php declare(strict_types=1);

namespace App\Shared\Domain\Value\Money;

enum Currency: string
{
    /**
     * Russian ruble currency identifier.
     */
    case RUB = 'RUB';

    /**
     * Euro currency identifier.
     */
    case EUR = 'EUR';
    
    /**
     * US dollar currency identifier.
     */
    case USD = 'USD';

    /**
     * @phpstan-return string
     */
    public function symbol(): string
    {
        return match($this) {
            self::RUB => '₽',
            self::USD => '$',
            self::EUR => '€',
        };
    }

    /**
     * @phpstan-return string
     */
    public function label(): string
    {
        return match($this) {
            self::RUB => 'Russian ruble',
            self::EUR => 'Euro',
            self::USD => 'US dollar',
        };
    }

    /**
     * @phpstan-return bool
     */
    public function isRub(): bool
    {
        return $this === self::RUB;
    }

    /**
     * @phpstan-return bool
     */
    public function isEur(): bool
    {
        return $this === self::EUR;
    }
    
    /**
     * @phpstan-return bool
     */
    public function isUsd(): bool
    {
        return $this === self::USD;
    }
}
