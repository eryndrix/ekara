<?php declare(strict_types=1);

namespace Foundation\Auth\Notification;

trait Notifiable
{
    /**
     * Provides database notifications.
     */
    use HasDatabaseNotifications;

    /**
     * Provides notification routing.
     */
    use RoutesNotifications;
}
