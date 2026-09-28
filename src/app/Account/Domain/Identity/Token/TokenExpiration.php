<?php declare(strict_types=1);

namespace App\Account\Domain\Identity\Token;

final readonly class TokenExpiration
{
    /**
     * @phpstan-param \DateTimeImmutable $expiresAt
     * @phpstan-param int $expiresIn
     */
    public function __construct(
        public private(set) \DateTimeImmutable $expiresAt,
        public private(set) int $expiresIn
    ) {}
}
