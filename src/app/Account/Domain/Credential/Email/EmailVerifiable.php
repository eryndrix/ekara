<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Email;

use App\Shared\Domain\Criterion\ClockInterface;

/**
 * @phpstan-require-extends \App\Account\Domain\User
 */
trait EmailVerifiable
{
    /**
     * @phpstan-var non-empty-string
     */
    private const string EMAIL_VERIFIED_AT = 'emailVerifiedAt';

    /**
     * @phpstan-return EmailVerifiedAt
     */
    public function emailVerified(): EmailVerifiedAt
    {
        return EmailVerifiedAt::fromNullable(
            value: $this->{self::EMAIL_VERIFIED_AT}
        );
    }

    /**
     * @phpstan-param ClockInterface $clock
     * @phpstan-return void
     *
     * @throws \DomainException
     */
    public function verifyEmail(ClockInterface $clock): void
    {
        if ($this->{self::EMAIL_VERIFIED_AT} !== null) {
            return;
        }

        $now = $clock->now();
        $this->{self::EMAIL_VERIFIED_AT} = $now;

        $this->record(event: new EmailVerified(
            userId: $this->id,
            verifiedAt: $now
        ));
    }

    /**
     * @phpstan-return void
     */
    public function forgetEmailVerification(): void
    {
        if ($this->{self::EMAIL_VERIFIED_AT} === null) {
            return;
        }

        $this->{self::EMAIL_VERIFIED_AT} = null;

        $this->record(event: new EmailUnverified(
            userId: $this->id
        ));
    }
}
