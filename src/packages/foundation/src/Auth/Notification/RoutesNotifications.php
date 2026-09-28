<?php declare(strict_types=1);

namespace Foundation\Auth\Notification;

use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Support\Str;

trait RoutesNotifications
{
    /**
     * @param mixed $instance
     * @return void
     */
    public function notify($instance): void
    {
        app(
            abstract: Dispatcher::class
        )->send(
            notifiables: $this,
            notification: $instance
        );
    }

    /**
     * @param mixed $instance
     * @param array|null $channels
     * 
     * @return void
     */
    public function notifyNow($instance, ?array $channels = null): void
    {
        app(
            abstract: Dispatcher::class
        )->sendNow(
            notifiables: $this,
            notification: $instance,
            channels: $channels
        );
    }

    /**
     * @param string $driver
     * @param \Illuminate\Notifications\Notification|null $notification
     * 
     * @return mixed
     */
    public function routeNotificationFor(
        $driver, $notification = null): mixed
    {
        if (method_exists(
            object_or_class: $this,
            method: $method = 'routeNotificationFor' . Str::studly(
                value: $driver
            )
        )) {
            return $this->{$method}($notification);
        }

        return match ($driver) {
            'database' => $this->notifications(),
            'mail' => (string) $this->{static::EMAIL_NAME},
            default => null,
        };
    }
}
