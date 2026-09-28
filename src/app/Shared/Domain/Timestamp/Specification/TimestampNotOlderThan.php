<?php declare(strict_types=1);

namespace App\Shared\Domain\Timestamp\Specification;

use App\Shared\Domain\Criterion\SpecificationInterface;

/**
 * @phpstan-implements SpecificationInterface<\DateTimeImmutable|null>
 */
final class TimestampNotOlderThan implements SpecificationInterface
{
    /**
     * @phpstan-param \DateTimeImmutable $since
     */
    public function __construct(
        private readonly \DateTimeImmutable $since
    ) {}

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
            return false;
        }

        return $candidate >= $this->since;
    }
}
