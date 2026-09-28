<?php declare(strict_types=1);

namespace App\Account\Application\Action\Login;

use App\Shared\Application\Action;
use App\Account\Domain\Repository\UserRepositoryInterface;
use App\Account\Application\Context\LoginContext;

final class ApplyRememberMeAction extends Action
{
    /**
     * @phpstan-param UserRepositoryInterface $repository
     */
    public function __construct(
        private UserRepositoryInterface $repository
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
        if (!$context->rememberMe) {
            return $next($context);
        }

        /** @phpstan-var \App\Account\Domain\User $user */
        $user = $context->user;
        $user->generateRememberToken();

        $this->repository->save(user: $user);

        return $next($context);
    }
}
