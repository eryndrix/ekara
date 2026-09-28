<?php declare(strict_types=1);

namespace App\Account\Domain\Credential\Phone;

use App\Shared\Domain\Event\Event;
use App\Shared\Domain\Value\Id\UserId;

final class PhoneVerified extends Event
{
    /**
     * @phpstan-param UserId $userId
     * @phpstan-param \DateTimeImmutable $verifiedAt
     */
    public function __construct(
        public private(set) UserId $userId,
        public private(set) \DateTimeImmutable $verifiedAt
    ) {}
}
