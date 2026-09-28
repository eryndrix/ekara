<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Process;

use App\Shared\Application\Process;
use App\Shared\Domain\Bus\ProcessBusInterface;
use Illuminate\Pipeline\Pipeline;

final class ProcessBus implements ProcessBusInterface
{
    /**
     * @phpstan-param Pipeline $pipeline
     */
    public function __construct(
        private readonly Pipeline $pipeline
    ) {}

    /**
     * @phpstan-param object $process
     * @phpstan-return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function run(object $process): mixed
    {
        $this->assertProcess(process: $process);

        return $this->pipeline->send(
            passable: $process->context
        )->through(
            pipes: $process->workflow
        )->via(
            method: 'handle'
        )->thenReturn();
    }

    /**
     * @phpstan-param object $process
     * @phpstan-assert Process<*, mixed> $process
     *
     * @throws \InvalidArgumentException
     */
    private function assertProcess(object $process): void
    {
        if (!$process instanceof Process) {
            throw new \InvalidArgumentException(
                message: sprintf(
                    'Expected %s, got %s.',
                    Process::class,
                    $process::class
                )
            );
        }
    }
}
