<?php declare(strict_types=1);

namespace App\Account\Domain\Identity\Device;

final readonly class AgentMetadata
{
    /**
     * @phpstan-param non-empty-string|null $browser
     * @phpstan-param non-empty-string|null $device
     * @phpstan-param non-empty-string|null $platform
     * @phpstan-param non-empty-string|null $robot
     */
    public function __construct(
        public private(set) ?string $browser = null,
        public private(set) ?string $device = null,
        public private(set) ?string $platform = null,
        public private(set) ?string $robot = null
    ) {}
}
