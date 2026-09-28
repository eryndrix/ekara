<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Clock;

use App\Shared\Domain\Criterion\ClockInterface;

final class FrozenClock implements ClockInterface
{
    /**
     * @phpstan-param \DateTimeImmutable $now
     */
    public function __construct(
        private \DateTimeImmutable $now
    ) {}

    /**
     * @phpstan-return \DateTimeImmutable
     */
    public function now(): \DateTimeImmutable
    {
        return $this->now;
    }

    /**
     * @phpstan-param \DateTimeImmutable $now
     * @phpstan-return void
     */
    public function set(\DateTimeImmutable $now): void
    {
        $this->now = $now;
    }

    /**
     * @phpstan-param \DateInterval $interval
     * @phpstan-return void
     */
    public function advance(\DateInterval $interval): void
    {
        $this->now = $this->now->add(interval: $interval);
    }
}
