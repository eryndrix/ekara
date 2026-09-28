<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Clock;

use App\Shared\Domain\Criterion\ClockInterface;

final class SystemClock implements ClockInterface
{
    /**
     * @phpstan-return \DateTimeImmutable
     */
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
