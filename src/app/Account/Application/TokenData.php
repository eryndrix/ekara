<?php declare(strict_types=1);

namespace App\Account\Application;

final readonly class TokenData
{
    /**
     * @phpstan-param string $accessToken
     * @phpstan-param \DateTimeImmutable|null $expiresAt
     */
    public function __construct(
        public private(set) string $accessToken,
        public private(set) ?\DateTimeImmutable $expiresAt
    ) {}
}
