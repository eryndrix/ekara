<?php declare(strict_types=1);

namespace App\Account\Application\Process;

use App\Shared\Application\Process;
use App\Account\Application\Action\Login\ApplyRememberMeAction;
use App\Account\Application\Action\Login\IssueAccessTokenAction;
use App\Account\Application\Action\Login\ResolveTokenExpirationAction;
use App\Account\Application\Action\Login\ResolveUserByEmailAction;
use App\Account\Application\Action\Login\VerifyPasswordAction;
use App\Account\Application\Command\LoginCommand;
use App\Account\Application\Context\LoginContext;

/**
 * @phpstan-extends Process<LoginContext, mixed>
 */
final class LoginProcess extends Process
{
    /**
     * @phpstan-var list<class-string<\App\Shared\Application\Action>>
     */
    public protected(set) array $workflow = [
        ResolveUserByEmailAction::class,
        VerifyPasswordAction::class,
        ApplyRememberMeAction::class,
        ResolveTokenExpirationAction::class,
        IssueAccessTokenAction::class,
    ];

    /**
     * @phpstan-param LoginCommand $command
     */
    public function __construct(
        private readonly LoginCommand $command
    ) {
        $this->context = new LoginContext(
            command: $command
        );
    }
}
