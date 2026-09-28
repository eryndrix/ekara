<?php declare(strict_types=1);

namespace App\Shared\Domain\Bus;

interface QueryBusInterface
{
    /**
     * @phpstan-param object $query
     * @phpstan-return mixed
     */
    public function ask(object $query): mixed;

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
