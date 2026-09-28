<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Type\Id;

use App\Shared\Domain\Value\Id\RoleId;

/**
 * @phpstan-extends UniqueIdType<RoleId>
 */
final class RoleIdType extends UniqueIdType
{
    /**
     * @phpstan-var class-string<RoleId>
     */
    public const string NAME = RoleId::class;

    /**
     * @phpstan-return class-string<RoleId>
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @phpstan-return class-string<RoleId>
     */
    public function getValueObjectClass(): string
    {
        return RoleId::class;
    }
}
