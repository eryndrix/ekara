<?php declare(strict_types=1);

namespace App\Account\Domain\Capability;

use App\Account\Domain\Avatar;
use App\Account\Domain\Credential\Email\Email;
use App\Account\Domain\Credential\Email\EmailChanged;
use App\Account\Domain\Credential\Phone\Phone;
use App\Account\Domain\Credential\Phone\PhoneChanged;
use App\Account\Domain\Credential\Password\Password;
use App\Account\Domain\Credential\Password\PasswordChanged;
use App\Shared\Domain\Criterion\ClockInterface;
use App\Shared\Domain\Value\Id\UserId;

/**
 * @phpstan-require-extends \App\Account\Domain\User
 */
trait UserModifiable
{
    /**
     * @phpstan-var non-empty-string
     */
    private const string EMAIL = 'email';

    /**
     * @phpstan-var non-empty-string
     */
    private const string PHONE = 'phone';

    /**
     * @phpstan-var non-empty-string
     */
    private const string PASSWORD = 'password';

    /**
     * @phpstan-var non-empty-string
     */
    private const string AVATAR = 'avatar';

    /**
     * @phpstan-var non-empty-string
     */
    private const string FIRST_NAME = 'firstName';

    /**
     * @phpstan-var non-empty-string
     */
    private const string LAST_NAME = 'lastName';

    /**
     * @phpstan-var non-empty-string
     */
    private const string BIO = 'bio';

    /**
     * @phpstan-param Avatar|null $avatar
     * @phpstan-return void
     */
    public function changeAvatar(?Avatar $avatar): void
    {
        if ($avatar !== null
            && $this->{self::AVATAR} !== null
            && $this->{self::AVATAR}->equals(other: $avatar)
        ) {
            return;
        }

        $this->{self::AVATAR} = $avatar;
    }

    /**
     * @phpstan-param string $firstName
     * @phpstan-return void
     */
    public function changeFirstName(string $firstName): void
    {
        if ($this->{self::FIRST_NAME} === $firstName) {
            return;
        }

        $this->{self::FIRST_NAME} = $firstName;
    }

    /**
     * @phpstan-param string $lastName
     * @phpstan-return void
     */
    public function changeLastName(string $lastName): void
    {
        if ($this->{self::LAST_NAME} === $lastName) {
            return;
        }

        $this->{self::LAST_NAME} = $lastName;
    }

    /**
     * @phpstan-param Email $email
     * @phpstan-return void
     */
    public function changeEmail(Email $email): void
    {
        if ($this->{self::EMAIL}->equals(other: $email)) {
            return;
        }

        $this->{self::EMAIL} = $email;
        $this->forgetEmailVerification();

        $this->record(event: new EmailChanged(
            userId: UserId::of(value: $this->getAuthIdentifier())
        ));
    }

    /**
     * @phpstan-param Phone $phone
     * @phpstan-return void
     */
    public function changePhone(Phone $phone): void
    {
        if ($this->{self::PHONE} !== null
            && $this->{self::PHONE}->equals(other: $phone)
        ) {
            return;
        }

        $this->{self::PHONE} = $phone;
        $this->forgetPhoneVerification();

        $this->record(event: new PhoneChanged(
            userId: UserId::of(value: $this->getAuthIdentifier())
        ));
    }

    /**
     * @phpstan-param Password $password
     * @phpstan-param ClockInterface $clock
     *
     * @phpstan-return void
     */
    public function changePassword(
        #[\SensitiveParameter] Password $password,
        ClockInterface $clock): void
    {
        if ($this->{self::PASSWORD}->equals(other: $password)) {
            return;
        }

        $this->{self::PASSWORD} = $password;
        $this->recordPasswordChange(clock: $clock);

        $this->record(event: new PasswordChanged(
            userId: UserId::of(value: $this->getAuthIdentifier()),
            changedAt: $clock->now()
        ));
    }

    /**
     * @phpstan-param string|null $bio
     * @phpstan-return void
     */
    public function changeBio(?string $bio): void
    {
        if ($this->{self::BIO} === $bio) {
            return;
        }

        $this->{self::BIO} = $bio;
    }
}
