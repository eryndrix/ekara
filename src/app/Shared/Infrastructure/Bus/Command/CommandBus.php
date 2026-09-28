<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use Illuminate\Contracts\Bus\Dispatcher;
use App\Shared\Domain\Bus\CommandBusInterface;
use App\Shared\Application\Outcome\Result;
use App\Shared\Application\Payload\Envelope;

final class CommandBus implements CommandBusInterface
{
    /**
     * @phpstan-param Dispatcher $dispatcher
     */
    public function __construct(
        private readonly Dispatcher $dispatcher
    ) {}

    /**
     * @phpstan-param object $command
     * @phpstan-return Result<Envelope<mixed>, \Throwable>
     */
    public function send(object $command): Result
    {
        try {
            /** @phpstan-var Envelope<mixed> $envelope */
            $envelope = $this->dispatcher->dispatchSync(
                command: $command
            );

            return Result::success(value: $envelope);
        }

        catch (\Throwable $e) {
            return Result::failure(error: $e);
        }
    }

    /**
     * @phpstan-param array<
     *     class-string<object>,
     *     class-string<object>
     * > $map
     *
     * @phpstan-return void
     */
    public function register(array $map): void
    {
        $this->dispatcher->map(map: $map);
    }
}
