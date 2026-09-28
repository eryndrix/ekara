<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Logging;

use Illuminate\Support\Facades\Log;

final class SlowQueryLogger
{
    /**
     * @phpstan-var string
     */
    private const CHANNEL = 'slow-queries';

    /**
     * @phpstan-param string $sql
     * @phpstan-param array<int, mixed> $bindings
     * @phpstan-param float $time
     * 
     * @phpstan-return void
     */
    public static function log(
        string $sql,
        array $bindings,
        float $time
    ): void {
        Log::channel(
            channel: self::CHANNEL
        )->warning(
            message: 'Slow query detected',
            context: [
                'sql' => $sql,
                'bindings' => $bindings,
                'time_ms' => $time,
            ]
        );
    }
}
