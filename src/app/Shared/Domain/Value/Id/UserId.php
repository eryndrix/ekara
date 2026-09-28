<?php declare(strict_types=1);

namespace App\Shared\Domain\Value\Id;

/**
 * @phpstan-extends UniqueId<UserId>
 */
final class UserId extends UniqueId
{
    /**
     * @phpstan-use IdFactory<UserId>
     */
    use IdFactory;
}
