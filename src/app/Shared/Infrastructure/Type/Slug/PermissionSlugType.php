<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Type\Slug;

use App\Shared\Domain\Value\Slug\PermissionSlug;

/**
 * @phpstan-extends UniqueSlugType<PermissionSlug>
 */
final class PermissionSlugType extends UniqueSlugType
{
    /**
     * @phpstan-var class-string<PermissionSlug>
     */
    public const string NAME = PermissionSlug::class;

    /**
     * @phpstan-return class-string<PermissionSlug>
     */
    public function getName(): string
    {
        return self::NAME;
    }
    
    /**
     * @phpstan-return class-string<PermissionSlug>
     */
    public function getValueObjectClass(): string
    {
        return PermissionSlug::class;
    }
}
