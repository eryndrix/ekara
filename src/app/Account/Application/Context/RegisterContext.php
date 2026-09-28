<?php declare(strict_types=1);

namespace App\Account\Application\Context;

use App\Shared\Application\Context;
use App\Account\Application\Command\RegisterCommand;
use App\Shared\Domain\Value\Id\UserId;
use App\Account\Domain\User;

/**
 * @phpstan-property-read string $firstName
 * @phpstan-property-read string $lastName
 * @phpstan-property-read string $email
 * @phpstan-property-read string $password
 */
final class RegisterContext extends Context
{
    /**
     * @phpstan-var RoleId|null
     */
    public ?RoleId $roleId = null;

    /**
     * @phpstan-var User|null
     */
    public ?User $user = null;

    /**
     * @phpstan-param RegisterCommand $command
     */
    public function __construct(RegisterCommand $command)
    {
        parent::__construct(command: $command);
    }
}
