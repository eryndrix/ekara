<?php declare(strict_types=1);

namespace Foundation\Auth\Notification;

use Illuminate\Notifications\DatabaseNotification;

trait HasDatabaseNotifications
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder<DatabaseNotification>
     */
    public function notifications()
    {
        return DatabaseNotification::query()->where(
            column: 'notifiable_type',
            operator: '=',
            value: static::class
        )->where(
            column: 'notifiable_id',
            operator: '=',
            value: $this->getAuthIdentifier()
        )->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder<DatabaseNotification>
     */
    public function readNotifications()
    {
        return $this->notifications()->read();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder<DatabaseNotification>
     */
    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }
}
