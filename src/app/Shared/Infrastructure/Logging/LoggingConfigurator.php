<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Logging;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Shared\Domain\Logging\LoggerInterface;
use App\Shared\Domain\Logging\ExceptionLoggerInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

final class LoggingConfigurator extends ServiceProvider
    implements DeferrableProvider
{
    /**
     * @phpstan-var int
     */
    private int $threshold = 100;

    /**
     * @phpstan-return void
     */
    public function boot(): void
    {
        $debug = Config::get(key: 'app.debug', default: 'true');
        
        if (!is_bool(value: $debug) || !$debug) {
            $threshold = Config::get(
                key: 'database.slow_query_threshold',
                default: 100
            );
            
            $this->threshold = is_int(value: $threshold)
                ? $threshold
                : 100;

            DB::listen(
                callback: function (QueryExecuted $query): void {
                    if ($query->time < $this->threshold) {
                        return;
                    }

                    /** @phpstan-var array<int, mixed> $bindings */
                    $bindings = $query->bindings;

                    SlowQueryLogger::log(
                        sql: $query->sql,
                        bindings: $bindings,
                        time: $query->time
                    );
                }
            );
        }
    }
    
    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $this->app->bind(
            abstract: LoggerInterface::class,
            concrete: Logger::class
        );

        $this->app->singleton(
            abstract: ExceptionLoggerInterface::class,
            concrete: ExceptionLogger::class
        );
    }

    /**
     * @phpstan-return array<int, class-string>
     */
    public function provides(): array
    {
        return [ExceptionLoggerInterface::class];
    }
}
