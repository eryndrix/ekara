<?php declare(strict_types=1);

namespace App\Shared\Domain\Event;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;

abstract class Event
{
    /**
     * Enables dispatching events using Laravel's event system.
     */
    use Dispatchable;

    /**
     * Supports interaction with WebSockets and broadcasting.
     */
    use InteractsWithSockets;
}
