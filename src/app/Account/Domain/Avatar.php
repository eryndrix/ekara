<?php declare(strict_types=1);

namespace App\Account\Domain;

use App\Shared\Domain\Primitive;

/**
 * @phpstan-extends Primitive<string>
 */
final class Avatar extends Primitive
{
    /**
     * @phpstan-var string
     */
    private string $avatar;

    /**
     * @phpstan-param string $avatar
     * @throws \DomainException
     */
    public function __construct(string $avatar)
    {
        $avatar = trim(string: $avatar);

        if (!self::isValid(value: $avatar)) {
            throw new \DomainException(
                message: 'Avatar path is invalid.'
            );
        }

        $this->avatar = $avatar;
    }

    /**
     * @phpstan-param string $value
     * @phpstan-return self
     */
    public static function of(string $value): self
    {
        return new self(avatar: $value);
    }

    /**
     * @phpstan-param string $value
     */
    public static function isValid(string $value): bool
    {
        $value = trim(string: $value);

        return $value !== ''
            && mb_strlen(string: $value) <= 255;
    }

    /**
     * @phpstan-return string
     */
    public function value(): string
    {
        return $this->avatar;
    }

    /**
     * @phpstan-return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
