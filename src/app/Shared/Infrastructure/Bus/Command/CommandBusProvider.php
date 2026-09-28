<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Shared\Domain\Bus\CommandBusInterface;
use App\Shared\Infrastructure\Persistence\TransactionMiddleware;
use App\Shared\Infrastructure\Logging\LoggingMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Bus\Dispatcher;

final class CommandBusProvider extends ServiceProvider
    implements DeferrableProvider
{
    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: 'bus.dispatcher.command',
            concrete: function (Application $app): Dispatcher {
                return new Dispatcher(container: $app)->pipeThrough(
                    pipes: [
                        TransactionMiddleware::class,
                        LoggingMiddleware::class,
                    ]
                );
            }
        );

        $this->app->singleton(
            abstract: CommandBusInterface::class,
            concrete: function (Application $app): CommandBus {
                return new CommandBus(
                    dispatcher: $app->make(
                        abstract: 'bus.dispatcher.command'
                    )
                );
            }
        );
    }

    /**
     * @phpstan-return array<int, string>
     */
    public function provides(): array
    {
        return [
            CommandBusInterface::class,
            'bus.dispatcher.command',
        ];
    }
}
