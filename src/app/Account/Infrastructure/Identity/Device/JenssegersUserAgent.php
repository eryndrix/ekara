<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Identity\Device;

use App\Account\Domain\Identity\Device\AgentMetadata;
use App\Account\Domain\Identity\Device\DeviceType;
use App\Account\Domain\Identity\Device\UserAgentInterface;
use Jenssegers\Agent\Agent;

final class JenssegersUserAgent implements UserAgentInterface
{
    /**
     * @phpstan-param Agent $agent
     */
    public function __construct(
        private readonly Agent $agent
    ) {}

    /**
     * @phpstan-return DeviceType
     */
    public function type(): DeviceType
    {
        return match (true) {
            $this->agent->isRobot() => DeviceType::Robot,
            $this->agent->isTablet() => DeviceType::Tablet,
            $this->agent->isMobile() => DeviceType::Mobile,
            $this->agent->isDesktop() => DeviceType::Desktop,
            default => DeviceType::Unknown,
        };
    }

    /**
     * @phpstan-return AgentMetadata
     */
    public function metadata(): AgentMetadata
    {
        return new AgentMetadata(
            browser: $this->normalize(
                value: $this->agent->browser()
            ),
            device: $this->normalize(
                value: $this->agent->device()
            ),
            platform: $this->normalize(
                value: $this->agent->platform()
            ),
            robot: $this->normalize(
                value: $this->agent->robot()
            )
        );
    }

    /**
     * @phpstan-param string|bool|null $value
     * @phpstan-return non-empty-string|null
     */
    private function normalize(string|bool|null $value): ?string
    {
        if (!is_string(value: $value)) {
            return null;
        }

        $value = trim(string: $value);

        return $value !== '' ? $value : null;
    }
}
