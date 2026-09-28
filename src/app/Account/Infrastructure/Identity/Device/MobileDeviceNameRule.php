<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Identity\Device;

use App\Account\Domain\Identity\Device\AgentMetadata;
use App\Account\Domain\Identity\Device\DeviceNameRuleInterface;
use App\Account\Domain\Identity\Device\DeviceType;

final class MobileDeviceNameRule implements DeviceNameRuleInterface
{
    /**
     * @phpstan-param DeviceType $type
     * @phpstan-return bool
     */
    public function supports(DeviceType $type): bool
    {
        return $type === DeviceType::Mobile
            || $type === DeviceType::Tablet;
    }

    /**
     * @phpstan-param AgentMetadata $metadata
     * @phpstan-return non-empty-string
     */
    public function apply(AgentMetadata $metadata): string
    {
        $parts = array_filter(
            array: [
                $metadata->device,
                $metadata->platform,
            ],
            callback: static fn (?string $value): bool
                => $value !== null
        );

        $name = implode(
            separator: ' ',
            array: $parts
        );

        return $name !== '' ? $name : 'Unknown device';
    }
}
