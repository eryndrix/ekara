<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use Illuminate\Contracts\Events\Dispatcher;
use App\Shared\Domain\Bus\EventBusInterface;
use App\Shared\Domain\Event\Event;

final class EventBus implements EventBusInterface
{
    /**
     * @phpstan-param Dispatcher $dispatcher
     */
    public function __construct(
        private readonly Dispatcher $dispatcher
    ) {}

    /**
     * @phpstan-param Event $event
     * @phpstan-return void
     */
    public function dispatch(Event $event): void
    {
        $this->dispatcher->dispatch(event: $event);
    }
}
