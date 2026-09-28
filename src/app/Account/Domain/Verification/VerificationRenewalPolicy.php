<?php declare(strict_types=1);

namespace App\Account\Domain\Verification;

use App\Shared\Domain\Criterion\SpecificationInterface;

/**
 * @phpstan-type VerifiedAt \DateTimeImmutable|null
 */
final class VerificationRenewalPolicy
{
    /**
     * @phpstan-param SpecificationInterface<VerifiedAt> $needsRenewal
     * @phpstan-param int $days
     */
    public function __construct(
        private readonly SpecificationInterface $needsRenewal,
        private readonly int $days
    ) {}

    /**
     * @phpstan-param VerifiedAt $verifiedAt
     * @phpstan-return VerificationRenewalDecision
     */
    public function decide(
        ?\DateTimeImmutable $verifiedAt): VerificationRenewalDecision
    {
        if (!$this->needsRenewal->isSatisfiedBy(
            candidate: $verifiedAt
        )) {
            return VerificationRenewalDecision::notRequired();
        }

        return VerificationRenewalDecision::required(
            reason: "Verification must be renewed every {$this->days} days."
        );
    }
}
