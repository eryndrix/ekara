<?php declare(strict_types=1);

namespace App\Account\Domain\Identity\Device;

interface DeviceResolverInterface
{
    /**
     * @phpstan-return non-empty-string
     */
    public function resolve(): string;
}
