<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Type\Slug;

use Doctrine\DBAL\Types\Type as SlugType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Shared\Domain\Value\Slug\UniqueSlug;
use Doctrine\DBAL\Types\Types;

/**
 * @phpstan-template TSlugType of UniqueSlug
 */
abstract class UniqueSlugType extends SlugType
{
    /**
     * @phpstan-return class-string<TSlugType>
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
        return Types::STRING;
    }

    /**
     * @phpstan-param mixed $value
     * @phpstan-param AbstractPlatform $platform
     * 
     * @phpstan-return TSlugType|null
     */
    public function convertToPHPValue(
        mixed $value, AbstractPlatform $platform): ?UniqueSlug
    {
        if (is_null(value: $value)) {
            return null;
        }
        
        $valueObjectClass = $this->getValueObjectClass();

        /** @phpstan-var TSlugType $valueObject */
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
        if ($value instanceof UniqueSlug) {
            return (string) $value;
        }
        
        return null;
    }
}
