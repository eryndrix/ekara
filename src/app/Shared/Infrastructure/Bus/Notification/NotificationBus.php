<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Notification;

use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Notifications\AnonymousNotifiable;
use App\Shared\Domain\Bus\NotificationBusInterface;
use App\Shared\Infrastructure\Notification;

/**
 * @phpstan-implements NotificationBusInterface<Notification>
 */
final class NotificationBus implements NotificationBusInterface
{
    /**
     * @phpstan-param Dispatcher $dispatcher
     */
    public function __construct(
        private readonly Dispatcher $dispatcher
    ) {}

    /**
     * @phpstan-param object $notifiable
     * @phpstan-param Notification $notification
     * 
     * @phpstan-return void
     */
    public function send(
        object $notifiable,
        object $notification
    ): void {
        $this->dispatcher->send(
            notifiables: $notifiable,
            notification: $notification
        );
    }

    /**
     * @phpstan-param iterable<object> $notifiables
     * @phpstan-param Notification $notification
     * 
     * @phpstan-return void
     */
    public function sendToMany(
        iterable $notifiables,
        object $notification
    ): void {
        $this->dispatcher->send(
            notifiables: $notifiables,
            notification: $notification
        );
    }

    /**
     * @phpstan-param object $notifiable
     * @phpstan-param Notification $notification
     * @phpstan-param list<string>|null $channels
     * 
     * @phpstan-return void
     */
    public function sendNow(
        object $notifiable,
        object $notification,
        ?array $channels = null
    ): void {
        $this->dispatcher->sendNow(
            notifiables: $notifiable,
            notification: $notification,
            channels: $channels
        );
    }

    /**
     * @phpstan-param string $channel
     * @phpstan-param mixed $route
     * @phpstan-param Notification $notification
     * 
     * @phpstan-return void
     */
    public function sendOnDemand(
        string $channel,
        mixed $route,
        object $notification
    ): void {
        $anonymous = new AnonymousNotifiable()->route(
            channel: $channel,
            route: $route
        );

        $this->dispatcher->send(
            notifiables: $anonymous,
            notification: $notification
        );
    }
}
