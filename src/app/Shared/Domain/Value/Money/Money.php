<?php declare(strict_types=1);

namespace App\Shared\Domain\Value\Money;

use Doctrine\ORM\Mapping as ORM;
use App\Shared\Domain\Primitive;

/**
 * @phpstan-template TCents
 * @phpstan-extends Primitive<int>
 */
#[ORM\MappedSuperclass]
abstract class Money extends Primitive
{
    /**
     * @phpstan-param int $cents
     * @phpstan-return static
     */
    abstract public static function fromCents(int $cents): static;

    /**
     * @phpstan-param float $amount
     * @phpstan-return static
     */
    public static function fromAmount(float $amount): static
    {
        $cents = (int) round(num: $amount * 100);
        return static::fromCents(cents: $cents);
    }

    /**
     * @phpstan-return int
     */
    abstract public function value(): int;

    /**
     * @phpstan-return float
     */
    public function amount(): float
    {
        return $this->value() / 100.0;
    }

    /**
     * @phpstan-return string
     */
    public function formatted(): string
    {
        return number_format(
            num: $this->value(),
            decimals: 2,
            decimal_separator: ',',
            thousands_separator: ' '
        );
    }

    /**
     * @phpstan-return string
     */
    public function __toString(): string
    {
        return $this->formatted();
    }
}
