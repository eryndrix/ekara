<?php declare(strict_types=1);

namespace App\Shared\Domain\Timestamp\Specification;

use App\Shared\Domain\Criterion\SpecificationInterface;

/**
 * @phpstan-implements SpecificationInterface<\DateTimeImmutable|null>
 */
final class StaleTimestamp implements SpecificationInterface
{
    /**
     * @phpstan-param \DateInterval $interval
     * @phpstan-param \DateTimeImmutable $now
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        private readonly \DateInterval $interval,
        private readonly \DateTimeImmutable $now
    ) {
        if ($interval->invert !== 0) {
            throw new \InvalidArgumentException(
                message: 'Interval must be positive.'
            );
        }
    }

    /**
     * @phpstan-param mixed $candidate
     * @phpstan-return bool
     *
     * @throws \InvalidArgumentException
     */
    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof \DateTimeImmutable
            && $candidate !== null
        ) {
            throw new \InvalidArgumentException(
                message: 'Candidate must be \DateTimeImmutable or null.'
            );
        }

        if ($candidate === null) {
            return true;
        }

        return $candidate < $this->now->sub(
            interval: $this->interval
        );
    }
}
