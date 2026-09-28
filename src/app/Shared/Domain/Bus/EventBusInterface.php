<?php declare(strict_types=1);

namespace App\Shared\Domain\Bus;

use App\Shared\Domain\Event\Event;

interface EventBusInterface
{
    /**
     * @phpstan-param Event $event
     * @phpstan-return void
     */
    public function dispatch(Event $event): void;
}
