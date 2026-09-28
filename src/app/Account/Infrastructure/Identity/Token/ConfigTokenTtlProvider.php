<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Identity\Token;

use App\Account\Domain\Identity\Token\TokenExpiration;
use App\Account\Domain\Identity\Token\TokenExpirationInterface;
use App\Shared\Domain\Criterion\ClockInterface;

final class ConfigTokenTtlProvider implements TokenExpirationInterface
{
    /**
     * @phpstan-param ClockInterface $clock
     */
    public function __construct(
        private readonly ClockInterface $clock
    ) {}

    /**
     * @phpstan-return TokenExpiration|null
     *
     * @throws \RuntimeException
     */
    public function provide(): ?TokenExpiration
    {
        $minutes = $this->expiration();

        if ($minutes === null) {
            return null;
        }

        $expiresAt = $this->clock->now()->add(
            interval: new \DateInterval(
                duration: sprintf('PT%dM', $minutes)
            )
        );

        return new TokenExpiration(
            expiresAt: $expiresAt,
            expiresIn: $minutes * 60
        );
    }

    /**
     * @phpstan-return int|null
     *
     * @throws \RuntimeException
     */
    private function expiration(): ?int
    {
        /** @phpstan-var int|float|numeric-string|null $ttl */
        $ttl = config(key: 'sanctum.expiration');

        if (is_null(value: $ttl)) {
            return null;
        }

        $minutes = (int) $ttl;

        if ($minutes <= 0) {
            throw new \RuntimeException(
                message: sprintf(
                    'Expiration must be positive: %d',
                    $minutes
                )
            );
        }

        return $minutes;
    }
}
