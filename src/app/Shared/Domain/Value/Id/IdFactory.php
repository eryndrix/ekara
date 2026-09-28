<?php declare(strict_types=1);

namespace App\Shared\Domain\Value\Id;

/**
 * @template TId of UniqueId
 */
trait IdFactory 
{
    /**
     * @internal
     * 
     * @phpstan-param string $id
     * @phpstan-return static
     */
    protected static function make(string $id): static
    {
        return new static(id: $id);
    }
}
