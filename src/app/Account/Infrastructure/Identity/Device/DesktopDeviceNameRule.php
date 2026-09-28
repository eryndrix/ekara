<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Identity\Device;

use App\Account\Domain\Identity\Device\AgentMetadata;
use App\Account\Domain\Identity\Device\DeviceNameRuleInterface;
use App\Account\Domain\Identity\Device\DeviceType;

final class DesktopDeviceNameRule implements DeviceNameRuleInterface
{
    /**
     * @phpstan-param DeviceType $type
     * @phpstan-return bool
     */
    public function supports(DeviceType $type): bool
    {
        return $type->isDesktop();
    }

    /**
     * @phpstan-param AgentMetadata $metadata
     * @phpstan-return non-empty-string
     */
    public function apply(AgentMetadata $metadata): string
    {
        $platform = $metadata->platform ?? 'Unknown OS';
        $browser  = $metadata->browser ?? 'Unknown browser';

        return "{$platform} / {$browser}";
    }
}
