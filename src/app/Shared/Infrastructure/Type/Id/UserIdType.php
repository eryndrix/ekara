<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Type\Id;

use App\Shared\Domain\Value\Id\UserId;

/**
 * @phpstan-extends UniqueIdType<UserId>
 */
final class UserIdType extends UniqueIdType
{
    /**
     * @phpstan-var class-string<UserId>
     */
    public const string NAME = UserId::class;

    /**
     * @phpstan-return class-string<UserId>
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @phpstan-return class-string<UserId>
     */
    public function getValueObjectClass(): string
    {
        return UserId::class;
    }
}
