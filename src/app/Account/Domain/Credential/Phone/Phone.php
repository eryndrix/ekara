<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Phone;

use App\Shared\Domain\Primitive;

/**
 * @phpstan-extends Primitive<string>
 */
final class Phone extends Primitive
{
    /**
     * @phpstan-param string $phone
     * @throws \DomainException
     */
    public function __construct(private string $phone)
    {
        $phone = trim(string: $phone);
        $phone = preg_replace(
            pattern: '/[\s\-\(\)]++/',
            replacement: '',
            subject: $phone
        ) ?? '';
        
        $this->validateState(phone: $phone);

        $this->phone = $phone;
    }

    /**
     * @phpstan-param string $phone
     * @throws \DomainException
     */
    private function validateState(string $phone): void
    {
        $this->validateNotEmpty(phone: $phone);
        $this->validateFormat(phone: $phone);
        $this->validateLength(phone: $phone);
    }

    /**
     * @phpstan-param string $phone
     * @throws \DomainException
     */
    private function validateNotEmpty(string $phone): void
    {
        if ($phone === '') {
            throw new \DomainException(
                message: 'Phone cannot be empty.'
            );
        }
    }

    /**
     * @phpstan-param string $phone
     * @throws \DomainException
     */
    private function validateFormat(string $phone): void
    {
        $matched = preg_match(pattern: '/^\+[1-9]\d*$/', subject: $phone);

        if ($matched !== 1) {
            throw new \DomainException(
                message: 'Phone must be in E.164 format.'
            );
        }
    }

    /**
     * @phpstan-param string $phone
     * @throws \DomainException
     */
    private function validateLength(string $phone): void
    {
        if (strlen(string: $phone) > 16) {
            throw new \DomainException(
                message: 'Phone exceeds 15 digits in E.164 format.'
            );
        }
    }

    /**
     * @phpstan-param string $value
     * @phpstan-return self
     */
    public static function of(string $value): self
    {
        return new self(phone: $value);
    }

    /**
     * @phpstan-return string
     */
    public function value(): string
    {
        return $this->phone;
    }

    /**
     * @phpstan-return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
