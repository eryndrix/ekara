<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Logging;

use App\Shared\Domain\Logging\ExceptionLoggerInterface;

final class LoggingMiddleware
{
    /**
     * @phpstan-param ExceptionLoggerInterface $exceptionLogger
     */
    public function __construct(
        private readonly ExceptionLoggerInterface $exceptionLogger
    ) {}

    /**
     * @phpstan-param object $command
     * @phpstan-param \Closure(object):mixed $next
     *
     * @phpstan-return mixed
     *
     * @throws \Throwable
     */
    public function handle(object $command, \Closure $next): mixed
    {
        try {
            return $next($command);
        }

        catch (\Throwable $e) {
            $this->exceptionLogger->log(exception: $e);

            throw $e;
        }
    }
}
