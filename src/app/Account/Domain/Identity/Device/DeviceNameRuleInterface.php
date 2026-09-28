<?php declare(strict_types=1);

namespace App\Account\Domain\Identity\Device;

interface DeviceNameRuleInterface
{
    /**
     * @phpstan-param DeviceType $type
     * @phpstan-return bool
     */
    public function supports(DeviceType $type): bool;

    /**
     * @phpstan-param AgentMetadata $metadata
     * @phpstan-return non-empty-string
     */
    public function apply(AgentMetadata $metadata): string;
}
