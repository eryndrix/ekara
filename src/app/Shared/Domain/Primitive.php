<?php declare(strict_types=1);

namespace App\Shared\Domain;

/**
 * @phpstan-template TValue
 */
abstract class Primitive
{
    /**
     * @phpstan-template TOther
     * @phpstan-param Primitive<TOther> $other
     * @phpstan-return bool
     */
    public function equals(Primitive $other): bool
    {
        if (get_class(object: $this)
            !== get_class(object: $other)
        ) {
            return false;
        }

        return $this->value() === $other->value();
    }

    /**
     * @phpstan-return TValue
     */
    abstract public function value();
}
