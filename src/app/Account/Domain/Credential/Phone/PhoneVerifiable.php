<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Phone;

use App\Shared\Domain\Criterion\ClockInterface;

/**
 * @phpstan-require-extends \App\Account\Domain\User
 */
trait PhoneVerifiable
{
    /**
     * @phpstan-var non-empty-string
     */
    private const string PHONE_VERIFIED_AT = 'phoneVerifiedAt';

    /**
     * @phpstan-return PhoneVerifiedAt
     */
    public function phoneVerified(): PhoneVerifiedAt
    {
        return PhoneVerifiedAt::fromNullable(
            value: $this->{self::PHONE_VERIFIED_AT}
        );
    }

    /**
     * @phpstan-param ClockInterface $clock
     * @phpstan-return void
     *
     * @throws \DomainException
     */
    public function verifyPhone(ClockInterface $clock): void
    {
        if ($this->{self::PHONE_VERIFIED_AT} !== null) {
            return;
        }

        $now = $clock->now();
        $this->{self::PHONE_VERIFIED_AT} = $now;

        $this->record(event: new PhoneVerified(
            userId: $this->id,
            verifiedAt: $now
        ));
    }

    /**
     * @phpstan-return void
     */
    public function forgetPhoneVerification(): void
    {
        if ($this->{self::PHONE_VERIFIED_AT} === null) {
            return;
        }

        $this->{self::PHONE_VERIFIED_AT} = null;

        $this->record(event: new PhoneUnverified(
            userId: $this->id
        ));
    }
}
