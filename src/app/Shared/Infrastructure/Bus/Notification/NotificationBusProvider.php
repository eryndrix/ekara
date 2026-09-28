<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Notification;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Shared\Domain\Bus\NotificationBusInterface;

final class NotificationBusProvider extends ServiceProvider
    implements DeferrableProvider
{
    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: NotificationBusInterface::class,
            concrete: NotificationBus::class
        );
    }

    /**
     * @phpstan-return array<int, class-string>
     */
    public function provides(): array
    {
        return [NotificationBusInterface::class];
    }
}
