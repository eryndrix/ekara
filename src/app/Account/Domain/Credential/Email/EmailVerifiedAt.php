<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Email;

use App\Shared\Domain\Timestamp\Specification\PresentTimestamp;
use App\Account\Domain\Verification\VerificationRenewalPolicy;
use App\Shared\Domain\Timestamp\Specification\TimestampNotOlderThan;
use App\Account\Domain\Verification\VerificationRenewalDecision;
use App\Shared\Domain\Timestamp\Specification\StaleTimestamp;

final class EmailVerifiedAt
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
    public static function pending(): self
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
    public function isVerified(): bool
    {
        return new PresentTimestamp()->isSatisfiedBy(
            candidate: $this->value
        );
    }

    /**
     * @phpstan-param \DateTimeImmutable $since
     * @phpstan-return bool
     */
    public function isVerifiedSince(\DateTimeImmutable $since): bool
    {
        return new TimestampNotOlderThan(
            since: $since
        )->isSatisfiedBy(
            candidate: $this->value
        );
    }

    /**
     * @phpstan-param \DateTimeImmutable $now
     * @phpstan-param int $days
     * 
     * @phpstan-return bool
     */
    public function needsRenewal(
        \DateTimeImmutable $now, int $days = 365): bool
    {
        return new StaleTimestamp(
            interval: new \DateInterval(duration: "P{$days}D"),
            now: $now
        )->isSatisfiedBy(
            candidate: $this->value
        );
    }

    /**
     * @phpstan-param \DateTimeImmutable $now
     * @phpstan-param int $days
     * 
     * @phpstan-return VerificationRenewalDecision
     */
    public function renewalDecision(
        \DateTimeImmutable $now,
        int $days = 365): VerificationRenewalDecision
    {
        $policy = new VerificationRenewalPolicy(
            needsRenewal: new StaleTimestamp(
                interval: new \DateInterval(duration: "P{$days}D"),
                now: $now
            ),
            days: $days
        );

        return $policy->decide(verifiedAt: $this->value);
    }

    /**
     * @phpstan-return \DateTimeImmutable|null
     */
    public function value(): ?\DateTimeImmutable
    {
        return $this->value;
    }
}
