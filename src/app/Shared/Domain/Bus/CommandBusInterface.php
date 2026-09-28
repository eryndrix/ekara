<?php declare(strict_types=1);

namespace App\Shared\Domain\Bus;

interface CommandBusInterface
{
    /**
     * @phpstan-param object $command
     * @phpstan-return mixed
     */
    public function send(object $command): mixed;
    
    /**
     * @phpstan-param array<
     *     class-string<object>,
     *     class-string<object>
     * > $map
     * 
     * @phpstan-return void
     */
    public function register(array $map): void;
}
