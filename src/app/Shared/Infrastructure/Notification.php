<?php declare(strict_types=1);

namespace App\Shared\Infrastructure;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as LaravelNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class Notification extends LaravelNotification implements ShouldQueue
{
    /**
     * Enable queueable behavior for the notification.
     */
    use Queueable;
}
