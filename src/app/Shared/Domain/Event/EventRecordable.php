<?php declare(strict_types=1);

namespace App\Shared\Domain\Event;

trait EventRecordable
{
    /**
     * @phpstan-var list<Event>
     */
    private array $events = [];

    /**
     * @phpstan-param Event $event
     * @phpstan-return void
     */
    public function record(Event $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @phpstan-return list<Event>
     */
    public function release(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
