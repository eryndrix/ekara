<?php declare(strict_types=1);

namespace App\Account\Application\Handler;

use App\Shared\Application\Handler;
use App\Shared\Domain\Bus\ProcessBusInterface;
use App\Account\Application\Command\LoginCommand;
use App\Account\Application\Process\LoginProcess;
use App\Account\Application\Context\LoginContext;
use App\Account\Application\Outcome\LoginOutcome;
use App\Shared\Application\Payload\Envelope;

final class LoginHandler extends Handler
{
    /**
     * @phpstan-var LoginOutcome
     */
    private readonly LoginOutcome $outcome;

    /**
     * @phpstan-param ProcessBusInterface $processBus
     */
    public function __construct(
        private readonly ProcessBusInterface $processBus
    ) {
        $this->outcome = new LoginOutcome();
    }

    /**
     * @phpstan-param LoginCommand $command
     * @phpstan-return Envelope<
     *     \App\Account\Application\TokenData
     * >
     */
    public function handle(LoginCommand $command): Envelope
    {
        /** @phpstan-var LoginContext $result */
        $result = $this->processBus->run(
            process: new LoginProcess(command: $command)
        );

        return $this->outcome->form(context: $result);
    }
}
