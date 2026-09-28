<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Password;

use App\Shared\Domain\Timestamp\Specification\PresentTimestamp;
use App\Shared\Domain\Timestamp\Specification\TimestampNotOlderThan;
use App\Shared\Domain\Timestamp\Specification\StaleTimestamp;

final class PasswordChangedAt
{
    /**
     * @phpstan-param \DateTimeImmutable|null $value
     */
    private function __construct(
        private readonly ?\DateTimeImmutable $value
    ) {}

    /**
     * @phpstan-return self
     */
    public static function neverChanged(): self
    {
        return new self(value: null);
    }

    /**
     * @phpstan-param \DateTimeImmutable|null $value
     * @phpstan-return self
     */
    public static function fromNullable(?\DateTimeImmutable $value): self
    {
        return new self(value: $value);
    }

    /**
     * @phpstan-return bool
     */
    public function hasChanged(): bool
    {
        return new PresentTimestamp()->isSatisfiedBy(
            candidate: $this->value
        );
    }

    /**
     * @phpstan-param \DateTimeImmutable $since
     * @phpstan-return bool
     */
    public function hasChangedSince(\DateTimeImmutable $since): bool
    {
        return new TimestampNotOlderThan(
            since: $since
        )->isSatisfiedBy(
            candidate: $this->value
        );
    }

    /**
     * @phpstan-param \DateInterval $interval
     * @phpstan-param \DateTimeImmutable $now
     * 
     * @phpstan-return bool
     */
    public function isStale(
        \DateInterval $interval, \DateTimeImmutable $now): bool
    {
        return new StaleTimestamp(
            interval: $interval,
            now: $now
        )->isSatisfiedBy(
            candidate: $this->value
        );
    }

    /**
     * @phpstan-param int $days
     * @phpstan-param \DateTimeImmutable $now
     * 
     * @phpstan-return bool
     *
     * @throws \DomainException
     */
    public function isStaleAfterDays(
        int $days, \DateTimeImmutable $now): bool
    {
        if ($days < 0) {
            throw new \DomainException(
                message: 'Days must be non-negative.'
            );
        }

        return $this->isStale(
            interval: new \DateInterval(duration: "P{$days}D"),
            now: $now
        );
    }

    /**
     * @phpstan-return \DateTimeImmutable|null
     */
    public function value(): ?\DateTimeImmutable
    {
        return $this->value;
    }
}
