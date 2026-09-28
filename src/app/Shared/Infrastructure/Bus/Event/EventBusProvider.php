<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Shared\Domain\Bus\EventBusInterface;

final class EventBusProvider extends ServiceProvider
    implements DeferrableProvider
{
    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: EventBusInterface::class,
            concrete: EventBus::class
        );
    }

    /**
     * @phpstan-return array<int, class-string>
     */
    public function provides(): array
    {
        return [EventBusInterface::class];
    }
}
