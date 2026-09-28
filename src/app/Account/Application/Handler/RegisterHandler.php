<?php declare(strict_types=1);

namespace App\Account\Application\Handler;

use App\Shared\Application\Handler;
use App\Shared\Domain\Bus\ProcessBusInterface;
use App\Account\Application\Command\RegisterCommand;
use App\Account\Application\Process\RegisterProcess;
use App\Account\Application\Context\RegisterContext;
use App\Account\Application\Outcome\RegisterOutcome;
use App\Shared\Application\Payload\Envelope;

final class RegisterHandler extends Handler
{
    /**
     * @phpstan-var RegisterOutcome
     */
    private readonly RegisterOutcome $outcome;

    /**
     * @phpstan-param ProcessBusInterface $processBus
     */
    public function __construct(
        private readonly ProcessBusInterface $processBus
    ) {
        $this->outcome = new RegisterOutcome();
    }

    /**
     * @phpstan-param RegisterCommand $command
     * @phpstan-return Envelope<null>
     */
    public function handle(RegisterCommand $command): Envelope
    {
        /** @phpstan-var RegisterContext $result */
        $result = $this->processBus->run(
            process: new RegisterProcess(command: $command)
        );

        return $this->outcome->form(context: $result);
    }
}
