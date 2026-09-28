<?php declare(strict_types=1);

namespace App\Shared\Application;

use App\Shared\Application\Payload\Command;

/**
 * @template TCommand of Command
 */
abstract class Context
{
    /**
     * @phpstan-param TCommand $command
     */
    public function __construct(
        public private(set) Command $command
    ) {}

    /**
     * @phpstan-param string $name
     * @phpstan-return mixed
     */
    public function __get(string $name): mixed
    {
        /** @phpstan-ignore property.dynamicName */
        return $this->command->{$name} ?? null;
    }

    /**
     * @phpstan-param string $name
     * @phpstan-return bool
     */
    public function __isset(string $name): bool
    {
        /** @phpstan-ignore property.dynamicName */
        return isset($this->command->{$name});
    }
}
