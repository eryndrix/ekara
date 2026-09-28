<?php declare(strict_types=1);

namespace App\Account\Domain\Identity;

use Foundation\Auth\UserProvider;

abstract class Authenticatable extends UserProvider
{
    /**
     * @phpstan-var bool
     */
    protected static bool $autoPersistEmailVerifiedAt = false;
}
