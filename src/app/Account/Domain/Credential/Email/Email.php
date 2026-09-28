<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Email;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Shared\Domain\Primitive;

/**
 * @phpstan-extends Primitive<string>
 */
#[ORM\Embeddable]
final class Email extends Primitive
{
    /**
     * @phpstan-var string
     */
    #[ORM\Column( name: 'email', type: Types::STRING, length: 254, unique: true)]
    private string $email {
        set (string $value) {
            $this->email = $value
                |> trim(...)
                |> (fn (string $email): string => mb_strtolower(
                    string: $email,
                    encoding: 'UTF-8'
                ));
        }
    }

    /**
     * @phpstan-param string $email
     */
    public function __construct(string $email)
    {
        self::ensureValidEmail(email: $email);
        $this->email = $email;
    }

    /**
     * @phpstan-param string $email
     * @phpstan-return void
     * 
     * @throws \DomainException
     */
    private static function ensureValidEmail(string $email): void
    {
        if (!(bool) filter_var(
            value: $email,
            filter: FILTER_VALIDATE_EMAIL
        )) {
            throw new \DomainException(
                message: sprintf(
                    'Invalid Email Format: "%s"',
                    $email
                )
            );
        }
        
        self::ensureMaxLength(email: $email);
    }

    /**
     * @phpstan-param string $email
     * @phpstan-return void
     * 
     * @throws \DomainException
     */
    private static function ensureMaxLength(string $email): void
    {
        if (mb_strlen(string: $email, encoding: 'UTF-8') > 254) {
            throw new \DomainException(
                message: sprintf(
                    'Email length exceeds 254 characters: "%s"',
                    $email
                )
            );
        }
    }

    /**
     * @phpstan-param string $value
     * @phpstan-return self
     */
    public static function of(string $value): self
    {
        return new self(email: $value);
    }

    /**
     * @phpstan-param string $email
     * @phpstan-return bool
     */
    public static function isValid(string $email): bool
    {
        try {
            self::ensureValidEmail(email: $email);
            return true;
        }

        catch (\DomainException) {
            return false;
        }
    }

    /**
     * @phpstan-return string
     */
    public function value(): string
    {
        return $this->email;
    }

    /**
     * @phpstan-return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
