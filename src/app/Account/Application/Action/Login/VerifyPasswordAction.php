<?php declare(strict_types=1);

namespace App\Account\Application\Action\Login;

use App\Shared\Application\Action;
use App\Account\Application\Context\LoginContext;
use App\Account\Application\Exception\InvalidCredentialsException;
use App\Account\Domain\Credential\Password\Password;

final class VerifyPasswordAction extends Action
{
    /**
     * @phpstan-param LoginContext $context
     * @phpstan-param \Closure(LoginContext):mixed $next
     *
     * @phpstan-return mixed
     *
     * @throws InvalidCredentialsException
     */
    public function handle(LoginContext $context, \Closure $next): mixed
    {
        /** @phpstan-var \App\Account\Domain\User $user */
        $user = $context->user;

        /** @phpstan-var Password $password */
        $password = Password::fromHash(
            value: $user->getAuthPassword()
        );

        if (!$password->verify(password: $context->password)) {
            throw new InvalidCredentialsException();
        }

        return $next($context);
    }
}
