<?php declare(strict_types=1);

namespace App\Shared\Domain\Bus;

interface ProcessBusInterface
{
    /**
     * @phpstan-param object $process
     * @phpstan-return mixed
     */
    public function run(object $process): mixed;
}
