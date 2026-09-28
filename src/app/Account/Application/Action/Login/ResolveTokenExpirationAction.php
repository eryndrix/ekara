<?php declare(strict_types=1);

namespace App\Account\Application\Action\Login;

use App\Shared\Application\Action;
use App\Account\Domain\Identity\Token\TokenExpirationInterface;
use App\Account\Application\Context\LoginContext;

final class ResolveTokenExpirationAction extends Action
{
    /**
     * @phpstan-param TokenExpirationInterface $expiration
     */
    public function __construct(
        private TokenExpirationInterface $expiration
    ) {}

    /**
     * @phpstan-param LoginContext $context
     * @phpstan-param \Closure(LoginContext):mixed $next
     *
     * @phpstan-return mixed
     */
    public function handle(
        LoginContext $context, \Closure $next): mixed
    {
        $expiration = $this->expiration->provide();
        $context->expiresAt = $expiration?->expiresAt;

        return $next($context);
    }
}
