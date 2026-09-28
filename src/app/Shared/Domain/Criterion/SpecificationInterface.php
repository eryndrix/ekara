<?php declare(strict_types=1);

namespace App\Shared\Domain\Criterion;

/**
 * @phpstan-template TCandidate
 */
interface SpecificationInterface
{
    /**
     * @phpstan-param TCandidate $candidate
     * @phpstan-return bool
     */
    public function isSatisfiedBy(mixed $candidate): bool;
}
