<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Password;

use App\Shared\Domain\Criterion\ClockInterface;

/**
 * @phpstan-require-extends \App\Account\Domain\User
 */
trait PasswordTrackable
{
    /**
     * @phpstan-var non-empty-string
     */
    private const string PASSWORD_CHANGED_AT = 'passwordChangedAt';

    /**
     * @phpstan-return PasswordChangedAt
     */
    public function passwordChanged(): PasswordChangedAt
    {
        return PasswordChangedAt::fromNullable(
            value: $this->{self::PASSWORD_CHANGED_AT}
        );
    }

    /**
     * @phpstan-param ClockInterface $clock
     * @phpstan-return void
     */
    public function recordPasswordChange(ClockInterface $clock): void
    {
        $now = $clock->now();
        $this->{self::PASSWORD_CHANGED_AT} = $now;

        $this->record(event: new PasswordChanged(
            userId: $this->id,
            changedAt: $now
        ));
    }

    /**
     * @phpstan-return void
     */
    public function forgetPasswordChange(): void
    {
        if ($this->{self::PASSWORD_CHANGED_AT} === null) {
            return;
        }

        $this->{self::PASSWORD_CHANGED_AT} = null;

        $this->record(event: new PasswordReset(
            userId: $this->id
        ));
    }
}
