<?php declare(strict_types=1);

namespace App\Account\Application\Context;

use App\Shared\Application\Context;
use App\Account\Application\Command\LoginCommand;
use App\Account\Domain\User;

/**
 * @phpstan-property-read string $email
 * @phpstan-property-read string $password
 * @phpstan-property-read bool $rememberMe
 * 
 * @phpstan-extends Context<LoginCommand>
 */
final class LoginContext extends Context
{
    /**
     * @phpstan-var User|null
     */
    public ?User $user = null;

    /**
     * @phpstan-var \DateTimeImmutable|null
     */
    public ?\DateTimeImmutable $expiresAt = null;

    /**
     * @phpstan-var string|null
     */
    public ?string $token = null;

    /**
     * @phpstan-param LoginCommand $command
     */
    public function __construct(LoginCommand $command)
    {
        parent::__construct(command: $command);
    }
}
