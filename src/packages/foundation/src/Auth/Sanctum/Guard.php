<?php declare(strict_types=1);

namespace Foundation\Auth\Sanctum;

use Foundation\Auth\UserProviderInterface;
use Laravel\Sanctum\Guard as SanctumGuard;

final class Guard extends SanctumGuard
{
    /**
     * @param mixed $tokenable
     * @return bool
     */
    protected function supportsTokens($tokenable = null): bool
    {
        return $tokenable instanceof UserProviderInterface;
    }
}
