<?php declare(strict_types=1);

namespace Foundation\Auth\Verification;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Auth\Notifications\VerifyEmail;

trait MustVerifyEmail
{
    /**
     * @return bool
     */
    public function hasVerifiedEmail(): bool
    {
        return $this->{static::EMAIL_VERIFIED_AT_NAME} !== null;
    }

    /**
     * @return bool
     */
    public function markEmailAsVerified(): bool
    {
        if ($this->{static::EMAIL_VERIFIED_AT_NAME} !== null) {
            return false;
        }

        $this->{static::EMAIL_VERIFIED_AT_NAME} = new \DateTimeImmutable();
        $this->persistEmailVerifiedAt();

        return true;
    }

    /**
     * @return bool
     */
    public function markEmailAsUnverified(): bool
    {
        if ($this->{static::EMAIL_VERIFIED_AT_NAME} === null) {
            return false;
        }

        $this->{static::EMAIL_VERIFIED_AT_NAME} = null;
        $this->persistEmailVerifiedAt();

        return true;
    }

    /**
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(
            instance: new VerifyEmail()
        );
    }

    /**
     * @return string
     */
    public function getEmailForVerification(): string
    {
        return (string) $this->{static::EMAIL_NAME};
    }

    /**
     * @return void
     */
    protected function persistEmailVerifiedAt(): void
    {
        $em = app(abstract: EntityManagerInterface::class);

        $em->persist(object: $this);
        $em->flush();
    }
}
