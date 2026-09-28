<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Type;

use App\Account\Domain\Avatar;
use Doctrine\DBAL\Types\Type as UniqueType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Types;

final class AvatarType extends UniqueType
{
    /**
     * @phpstan-var class-string<Avatar>
     */
    public const string NAME = Avatar::class;

    /**
     * @phpstan-return class-string<Avatar>
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @phpstan-return class-string<Avatar>
     */
    public function getValueObjectClass(): string
    {
        return Avatar::class;
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
     * @phpstan-return Avatar|null
     * 
     * @throws \UnexpectedValueException
     */
    public function convertToPHPValue(
        mixed $value, AbstractPlatform $platform): ?Avatar
    {
        if ($value === null) {
            return null;
        }

        if (!is_string(value: $value)) {
            throw new \UnexpectedValueException(
                message: 'Avatar value must be a string.'
            );
        }

        $valueObjectClass = $this->getValueObjectClass();

        /** @phpstan-var Avatar $valueObject */ 
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
        if ($value instanceof Avatar) {
            return (string) $value;
        }
        
        return null;
    }
}
