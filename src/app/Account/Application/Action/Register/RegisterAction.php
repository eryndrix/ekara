<?php declare(strict_types=1);

namespace App\Account\Application\Auth\Register\Action;

use App\Account\Application\Auth\Register\Exception\DefaultRoleNotFoundException;
use App\Account\Application\Auth\Register\Exception\EmailAlreadyTakenException;
use App\Account\Application\Auth\Register\Runtime\RegisterContext;
use App\Account\Domain\Credential\Email\Email;
use App\Account\Domain\Credential\Password\Password;
use App\Account\Domain\Repository\UserRepositoryInterface;
use App\Account\Domain\Role;
use App\Account\Domain\User;
use App\Shared\Application\Action;
use App\Shared\Domain\Repository\RoleRepositoryInterface;
use App\Shared\Domain\Value\Slug\RoleSlug;
use App\Shared\Domain\Value\Id\RoleId;

final class RegisterAction extends Action
{
    /**
     * @phpstan-param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * @phpstan-param RegisterContext $context
     * @phpstan-param \Closure(RegisterContext):mixed $next
     *
     * @phpstan-return mixed
     *
     * @throws EmailAlreadyTakenException
     * @throws DefaultRoleNotFoundException
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \Throwable
     */
    public function handle(
        RegisterContext $context, \Closure $next): mixed
    {
        $email = Email::of(value: $context->email);

        $existing = $this->userRepository->findByEmail(
            email: $email
        );

        if ($existing instanceof User) {
            throw new EmailAlreadyTakenException();
        }

        $role = $this->roleRepository->findBySlug(
            slug: RoleSlug::of(value: Role::User->value)
        );

        if ($role === null) {
            throw new DefaultRoleNotFoundException();
        }

        $user = new User(
            firstName: $context->firstName,
            lastName: $context->lastName,
            email: $email,
            password: Password::fromPlain(
                value: $context->password
            ),
            roleId: $role->id
        );

        $this->userRepository->save(user: $user);

        return $next($context);
    }
}
