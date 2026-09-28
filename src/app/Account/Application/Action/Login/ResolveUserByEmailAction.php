<?php declare(strict_types=1);

namespace App\Account\Application\Action\Login;

use App\Shared\Application\Action;
use App\Account\Application\Context\LoginContext;
use App\Account\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Exception\UserNotFoundException;
use App\Account\Domain\Credential\Email\Email;
use App\Account\Domain\User;

final class ResolveUserByEmailAction extends Action
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
     *
     * @throws UserNotFoundException
     */
    public function handle(
        LoginContext $context, \Closure $next): mixed
    {
        $user = $this->repository->findByEmail(
            email: Email::of(value: $context->email)
        );

        if (!$user instanceof User) {
            throw new UserNotFoundException();
        }

        $context->user = $user;

        return $next($context);
    }
}
