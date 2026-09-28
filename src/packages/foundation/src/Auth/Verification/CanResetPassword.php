<?php declare(strict_types=1);

namespace Foundation\Auth\Verification;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

trait CanResetPassword
{
    /**
     * @return string
     */
    public function getEmailForPasswordReset(): string
    {
        return (string) $this->{static::EMAIL_NAME};
    }

    /**
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification(
        #[\SensitiveParameter] $token): void
    {
        $this->notify(
            instance: new ResetPasswordNotification(
                token: $token
            )
        );
    }
}
