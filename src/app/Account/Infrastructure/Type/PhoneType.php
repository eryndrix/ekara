<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Type;

use App\Account\Domain\Credential\Phone\Phone;
use Doctrine\DBAL\Types\Type as UniqueType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Types;

final class PhoneType extends UniqueType
{
    /**
     * @phpstan-var class-string<Phone>
     */
    public const string NAME = Phone::class;

    /**
     * @phpstan-return class-string<Phone>
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @phpstan-return class-string<Phone>
     */
    public function getValueObjectClass(): string
    {
        return Phone::class;
    }

    /**
     * @phpstan-param array<string, mixed> $fieldDeclaration
     * @phpstan-param AbstractPlatform $platform
     * 
     * @phpstan-return string
     */
    public function getSQLDeclaration(
        array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return Types::STRING;
    }

    /**
     * @phpstan-param mixed $value
     * @phpstan-param AbstractPlatform $platform
     * 
     * @phpstan-return Phone|null
     * 
     * @throws \UnexpectedValueException
     */
    public function convertToPHPValue(
        mixed $value, AbstractPlatform $platform): ?Phone
    {
        if ($value === null) {
            return null;
        }

        if (!is_string(value: $value)) {
            throw new \UnexpectedValueException(
                message: 'Phone value must be a string.'
            );
        }

        $valueObjectClass = $this->getValueObjectClass();

        /** @phpstan-var class-string<Phone> $valueObjectClass */
        $valueObject = new $valueObjectClass($value);

        return $valueObject;
    }

    /**
     * @phpstan-param mixed $value
     * @phpstan-param AbstractPlatform $platform
     * 
     * @phpstan-return string|null
     */
    public function convertToDatabaseValue(
        mixed $value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof Phone) {
            return (string) $value;
        }
        
        return null;
    }
}
