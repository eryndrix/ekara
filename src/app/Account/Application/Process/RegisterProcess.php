<?php declare(strict_types=1);

namespace App\Account\Application\Process;

use App\Shared\Application\Process;
use App\Account\Application\Command\RegisterCommand;
use App\Account\Application\Context\RegisterContext;
use App\Account\Application\Action\Register\ApplyRememberMeAction;
use App\Shared\Application\Payload\Envelope;

/**
 * @phpstan-extends Process<RegisterContext, Envelope<null>>
 */
final class RegisterProcess extends Process
{
    /**
     * @phpstan-var list<class-string<
     *     \App\Shared\Application\Action
     * >>
     */
    public protected(set) array $workflow = [
        ResolveUserByEmailAction::class,
        VerifyPasswordAction::class,
        ApplyRememberMeAction::class,
        ResolveTokenExpirationAction::class,
        IssueAccessTokenAction::class,
    ];

    /**
     * @phpstan-param RegisterCommand $command
     */
    public function __construct(
        private readonly RegisterCommand $command
    ) {
        $this->context = new RegisterContext(
            command: $command
        );
    }
}
