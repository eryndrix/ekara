<?php declare(strict_types=1);

namespace App\Shared\Domain\Value\Id;

use Doctrine\ORM\Mapping as ORM;
use App\Shared\Domain\Primitive;
use Illuminate\Support\Str;

/**
 * @template-covariant TId of UniqueId
 * @phpstan-extends Primitive<string>
 * @phpstan-consistent-constructor
 */
#[ORM\MappedSuperclass]
abstract class UniqueId extends Primitive
{
    /**
     * @phpstan-var string
     */
    private string $id;

    /**
     * @phpstan-param string $id
     */
    public function __construct(string $id)
    {
        $uuid = trim(string: $id);

        if (!Str::isUuid(value: $uuid, version: 7)) {
            throw new \DomainException(
                message: 'Invalid UUID format.'
            );
        }

        $this->id = $uuid;
    }

    /**
     * @internal
     * 
     * @phpstan-param string $id
     * @phpstan-return static<TId>
     */
    abstract protected static function make(string $id): static;

    /**
     * @phpstan-param string $value
     * @phpstan-return static<TId>
     */
    public static function of(string $value): static
    {
        return static::make(id: $value);
    }

    /**
     * @phpstan-return static<TId>
     */
    public static function generate(): static
    {
        return static::make(id: Str::uuid7()->toString());
    }

    /**
     * @phpstan-return string
     */
    public function value(): string
    {
        return $this->id;
    }

    /**
     * @phpstan-return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
