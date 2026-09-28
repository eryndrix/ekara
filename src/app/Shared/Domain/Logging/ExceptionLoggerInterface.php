<?php declare(strict_types=1);

namespace App\Shared\Domain\Logging;

interface ExceptionLoggerInterface
{
    /**
     * @phpstan-param \Throwable $exception
     * @phpstan-return void
     */
    public function log(\Throwable $exception): void;
}
