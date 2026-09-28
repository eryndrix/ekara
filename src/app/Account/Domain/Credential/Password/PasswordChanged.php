<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Password;

use App\Shared\Domain\Event\Event;
use App\Shared\Domain\Value\Id\UserId;

final class PasswordChanged extends Event
{
    /**
     * @phpstan-param UserId $userId
     * @phpstan-param \DateTimeImmutable $changedAt
     */
    public function __construct(
        public private(set) UserId $userId,
        public private(set) \DateTimeImmutable $changedAt
    ) {}
}
