<?php declare(strict_types=1);

namespace App\Shared\Domain\Criterion;

interface ClockInterface
{
    /**
     * @phpstan-return \DateTimeImmutable
     */
    public function now(): \DateTimeImmutable;
}
