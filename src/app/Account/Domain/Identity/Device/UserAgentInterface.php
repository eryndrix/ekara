<?php declare(strict_types=1);

namespace App\Account\Domain\Identity\Device;

interface UserAgentInterface
{
    /**
     * @phpstan-return DeviceType
     */
    public function type(): DeviceType;

    /**
     * @phpstan-return AgentMetadata
     */
    public function metadata(): AgentMetadata;
}
