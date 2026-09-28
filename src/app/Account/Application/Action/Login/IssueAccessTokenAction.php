<?php declare(strict_types=1);

namespace App\Account\Application\Action\Login;

use App\Shared\Application\Action;
use App\Account\Domain\Identity\Device\DeviceResolverInterface;
use App\Account\Application\Context\LoginContext;

final class IssueAccessTokenAction extends Action
{
    /**
     * @phpstan-param DeviceResolverInterface $deviceName
     */
    public function __construct(
        private readonly DeviceResolverInterface $deviceName
    ) {}

    /**
     * @phpstan-param LoginContext $context
     * @phpstan-param \Closure(LoginContext):mixed $next
     *
     * @phpstan-return mixed
     */
    public function handle(LoginContext $context, \Closure $next): mixed
    {
        /** @phpstan-var \App\Account\Domain\User $user */
        $user = $context->user;

        $token = $user->createToken(
            name: $this->deviceName->resolve(),
            abilities: ['*'],
            expiresAt: $context->expiresAt
        );

        $context->token = $token->plainTextToken;

        return $next($context);
    }
}
