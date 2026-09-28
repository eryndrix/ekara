<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Type\Id;

use App\Shared\Domain\Value\Id\UniqueId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type as IdType;
use Doctrine\DBAL\Types\Types;

/**
 * @phpstan-template TIdType of UniqueId
 */
abstract class UniqueIdType extends IdType
{
    /**
     * @phpstan-return class-string<TIdType>
     */
    abstract public function getValueObjectClass(): string;

    /**
     * @phpstan-param array<string, mixed> $fieldDeclaration
     * @phpstan-param AbstractPlatform $platform
     *
     * @phpstan-return string
     */
    public function getSQLDeclaration(
        array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return Types::GUID;
    }

    /**
     * @phpstan-param mixed $value
     * @phpstan-param AbstractPlatform $platform
     *
     * @phpstan-return TIdType|null
     */
    public function convertToPHPValue(
        mixed $value, AbstractPlatform $platform): ?UniqueId
    {
        if ($value === null) {
            return null;
        }

        $valueObjectClass = $this->getValueObjectClass();

        /** @phpstan-var TIdType $valueObject */
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
        if ($value instanceof UniqueId) {
            return (string) $value;
        }

        if (is_string(value: $value) && $value !== '') {
            return $value;
        }

        return null;
    }
}
