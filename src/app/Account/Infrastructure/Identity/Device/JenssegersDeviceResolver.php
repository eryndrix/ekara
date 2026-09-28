<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Identity\Device;

use App\Account\Domain\Identity\Device\DeviceNameRuleInterface;
use App\Account\Domain\Identity\Device\DeviceResolverInterface;
use App\Account\Domain\Identity\Device\UserAgentInterface;

final class JenssegersDeviceResolver implements DeviceResolverInterface
{
    /**
     * @phpstan-param UserAgentInterface $userAgent
     * @phpstan-param iterable<DeviceNameRuleInterface> $rules
     */
    public function __construct(
        private readonly UserAgentInterface $userAgent,
        private readonly iterable $rules
    ) {}

    /**
     * @phpstan-return non-empty-string
     */
    public function resolve(): string
    {
        $type = $this->userAgent->type();
        $metadata = $this->userAgent->metadata();

        foreach ($this->rules as $rule) {
            if ($rule->supports(type: $type)) {
                return $rule->apply(metadata: $metadata);
            }
        }

        return 'Unknown';
    }
}
