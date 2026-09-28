<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Password;

use App\Shared\Domain\Event\Event;
use App\Shared\Domain\Value\Id\UserId;

final class PasswordReset extends Event
{
    /**
     * @phpstan-param UserId $userId
     */
    public function __construct(
        public private(set) UserId $userId
    ) {}
}
