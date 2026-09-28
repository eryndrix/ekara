<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Query;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Shared\Domain\Bus\QueryBusInterface;
use App\Shared\Infrastructure\Logging\LoggingMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Bus\Dispatcher;

final class QueryBusProvider extends ServiceProvider
    implements DeferrableProvider
{
    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: 'bus.dispatcher.query',
            concrete: function (Application $app): Dispatcher {
                return new Dispatcher(container: $app)->pipeThrough(
                    pipes: [LoggingMiddleware::class]
                );
            }
        );

        $this->app->singleton(
            abstract: QueryBusInterface::class,
            concrete: function (Application $app): QueryBus {
                return new QueryBus(
                    dispatcher: $app->make(
                        abstract: 'bus.dispatcher.query'
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
            QueryBusInterface::class,
            'bus.dispatcher.query',
        ];
    }
}
