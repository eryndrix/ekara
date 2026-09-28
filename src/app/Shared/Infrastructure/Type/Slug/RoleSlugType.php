<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Type\Slug;

use App\Shared\Domain\Value\Slug\RoleSlug;

/**
 * @phpstan-extends UniqueSlugType<RoleSlug>
 */
final class RoleSlugType extends UniqueSlugType
{
    /**
     * @phpstan-var class-string<RoleSlug>
     */
    public const string NAME = RoleSlug::class;

    /**
     * @phpstan-return class-string<RoleSlug>
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @phpstan-return class-string<RoleSlug>
     */
    public function getValueObjectClass(): string
    {
        return RoleSlug::class;
    }
}
