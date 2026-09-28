<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Logging;

use App\Shared\Domain\Logging\LoggerInterface;
use App\Shared\Domain\Logging\ExceptionLoggerInterface;
use App\Shared\Domain\Logging\Attribute\{Level, Log};

final class ExceptionLogger implements ExceptionLoggerInterface
{
    /**
     * @phpstan-var array<string, string>
     */
    private readonly array $levels;

    /**
     * @phpstan-param LoggerInterface $logger
     */
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
        /** @phpstan-var array<string, string> $levels */
        $levels = config(
            key: 'exception-logger.exception_levels',
            default: []
        );

        $this->levels = $levels;
    }

    /**
     * @phpstan-param \Throwable $exception
     * @phpstan-return void
     */
    public function log(\Throwable $exception): void
    {
        $level = $this->resolve(exception: $exception);
        $message = $exception->getMessage();

        match ($level) {
            Level::DEBUG => $this->logger->debug(
                message: $message,
                e: $exception
            ),
            Level::INFO => $this->logger->info(
                message: $message,
                e: $exception
            ),
            Level::NOTICE => $this->logger->notice(
                message: $message,
                e: $exception
            ),
            Level::WARNING => $this->logger->warning(
                message: $message,
                e: $exception
            ),
            Level::ERROR => $this->logger->error(
                message: $message,
                e: $exception
            ),
            Level::CRITICAL => $this->logger->critical(
                message: $message,
                e: $exception
            ),
            Level::ALERT => $this->logger->alert(
                message: $message,
                e: $exception
            ),
            Level::EMERGENCY => $this->logger->emergency(
                message: $message,
                e: $exception
            )
        };
    }

    /**
     * @phpstan-param \Throwable $exception
     * @phpstan-return Level
     */
    private function resolve(\Throwable $exception): Level
    {
        $reflection = new \ReflectionClass(
            objectOrClass: $exception
        );

        $attributes = $reflection->getAttributes(
            name: Log::class
        );

        $log = array_first(
            array: $attributes)?->newInstance();

        if ($log instanceof Log) {
            return $log->level;
        }

        foreach ($this->levels as $class => $level) {
            if ($exception instanceof $class) {
                return Level::from(value: $level);
            }
        }

        /** @phpstan-var string $default */
        $default = config(
            key: 'exception-logger.default_level',
            default: 'error'
        );

        return Level::from(value: $default);
    }
}
