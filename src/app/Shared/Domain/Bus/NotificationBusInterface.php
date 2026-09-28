<?php declare(strict_types=1);

namespace App\Shared\Domain\Bus;

/**
 * @phpstan-template TNotification of object
 */
interface NotificationBusInterface
{
    /**
     * @phpstan-param object $notifiable
     * @phpstan-param TNotification $notification
     * 
     * @phpstan-return void
     */
    public function send(
        object $notifiable,
        object $notification
    ): void;

    /**
     * @phpstan-param iterable<object> $notifiables
     * @phpstan-param TNotification $notification
     * 
     * @phpstan-return void
     */
    public function sendToMany(
        iterable $notifiables,
        object $notification
    ): void;

    /**
     * @phpstan-param object $notifiable
     * @phpstan-param TNotification $notification
     * @phpstan-param list<string>|null $channels
     * 
     * @phpstan-return void
     */
    public function sendNow(
        object $notifiable,
        object $notification,
        ?array $channels = null
    ): void;

    /**
     * @phpstan-param string $channel
     * @phpstan-param mixed $route
     * @phpstan-param TNotification $notification
     * 
     * @phpstan-return void
     */
    public function sendOnDemand(
        string $channel,
        mixed $route,
        object $notification
    ): void;
}
