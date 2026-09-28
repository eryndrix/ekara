<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Password;

use App\Shared\Domain\Primitive;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Facades\Hash;

/**
 * @phpstan-extends Primitive<string>
 * @phpstan-consistent-constructor
 */
#[ORM\MappedSuperclass]
class HashPassword extends Primitive
{
    /**
     * @phpstan-var string
     */
    #[ORM\Column(name: 'password', type: 'string', length: 255)]
    protected string $hash;

    /**
     * @phpstan-param string $hash
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $hash)
    {
        $this->assertHashNotEmpty(hash: $hash);
        $this->assertHashFormat(hash: $hash);

        $this->hash = $hash;
    }

    /**
     * @phpstan-param string $hash
     * @phpstan-return void
     *
     * @throws \InvalidArgumentException
     */
    private function assertHashNotEmpty(string $hash): void
    {
        if ($hash === '') {
            throw new \InvalidArgumentException(
                message: 'Password hash cannot be empty.'
            );
        }
    }

    /**
     * @phpstan-param string $hash
     * @phpstan-return void
     *
     * @throws \InvalidArgumentException
     */
    private function assertHashFormat(string $hash): void
    {
        if (!str_starts_with(
            haystack: $hash,
            needle: '$2'
        ) && !str_starts_with(
            haystack: $hash,
            needle: '$argon2'
        )) {
            throw new \InvalidArgumentException(
                message: 'Invalid password hash format.'
            );
        }
    }

    /**
     * @phpstan-param string $value
     * @phpstan-return static
     *
     * @throws \InvalidArgumentException
     */
    public static function fromHash(string $value): static
    {
        if (!Hash::isHashed(value: $value)) {
            throw new \InvalidArgumentException(
                message: 'Invalid password hash.'
            );
        }

        return new static(hash: $value);
    }

    /**
     * @phpstan-return string
     */
    public function value(): string
    {
        return $this->hash;
    }

    /**
     * @phpstan-return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
