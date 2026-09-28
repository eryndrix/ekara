<?php declare(strict_types=1);

namespace App\Account\Domain\Identity\Token;

interface TokenExpirationInterface
{
    /**
     * @phpstan-return TokenExpiration|null
     */
    public function provide(): ?TokenExpiration;
}
