<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Password;

use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Facades\Hash;

#[ORM\Embeddable]
class Password extends HashPassword
{
    /**
     * @phpstan-var int
     */
    private const int MIN_LENGTH = 8;

    /**
     * @phpstan-var int
     */
    private const int MAX_LENGTH = 64;

    /**
     * @phpstan-param string $password
     * @phpstan-return bool
     */
    public static function isValid(string $password): bool
    {
        if ($password === '' || trim(string: $password) === '') {
            return false;
        }

        $length = mb_strlen(
            string: $password,
            encoding: 'UTF-8'
        );
        
        return $length >= self::MIN_LENGTH
            && $length <= self::MAX_LENGTH;
    }

    /**
     * @phpstan-param string $value
     * @phpstan-return self
     * 
     * @throws \DomainException
     */
    public static function fromPlain(string $value): self
    {
        if (!self::isValid(password: $value)) {
            throw new \DomainException(
                message: 'Password must be between 8 and 64 characters.'
            );
        }

        return new self(hash: Hash::make(value: $value));
    }

    /**
     * @phpstan-return array<string, mixed>
     */
    public function info(): array
    {
        /** @phpstan-var array<string, mixed> $info */
        $info = Hash::info(hashedValue: $this->hash);
        
        return $info;
    }

    /**
     * @phpstan-param string $password
     * @phpstan-return bool
     */
    public function verify(string $password): bool
    {
        return Hash::check(
            value: $password,
            hashedValue: $this->hash
        );
    }

    /**
     * @phpstan-return bool
     */
    public function needsRehash(): bool
    {
        return Hash::needsRehash(
            hashedValue: $this->hash
        );
    }
}
