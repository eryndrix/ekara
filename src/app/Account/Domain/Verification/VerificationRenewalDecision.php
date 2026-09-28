<?php declare(strict_types=1);

namespace App\Account\Domain\Verification;

final class VerificationRenewalDecision
{
    /**
     * @phpstan-param bool $required
     * @phpstan-param string|null $reason
     */
    private function __construct(
        private readonly bool $required,
        public private(set) ?string $reason = null
    ) {}

    /**
     * @phpstan-return self
     */
    public static function notRequired(): self
    {
        return new self(required: false);
    }

    /**
     * @phpstan-param string $reason
     * @phpstan-return self
     */
    public static function required(string $reason): self
    {
        return new self(
            required: true, reason: $reason);
    }

    /**
     * @phpstan-return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }
}
