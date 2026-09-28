<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Logging;

use App\Shared\Domain\Logging\LoggerInterface;
use Illuminate\Support\Facades\Log;

final class Logger implements LoggerInterface
{
    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function emergency(string $message, \Throwable $e): void
    {
        Log::emergency(
            message: $message,
            context: ContextBuilder::fromConfig(
                level: 'emergency',
                exception: $e
            )
        );
    }

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function alert(string $message, \Throwable $e): void
    {
        Log::alert(
            message: $message,
            context: ContextBuilder::fromConfig(
                level: 'alert',
                exception: $e
            )
        );
    }

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function critical(string $message, \Throwable $e): void
    {
        Log::critical(
            message: $message,
            context: ContextBuilder::fromConfig(
                level: 'critical',
                exception: $e
            )
        );
    }

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function error(string $message, \Throwable $e): void
    {
        Log::error(
            message: $message,
            context: ContextBuilder::fromConfig(
                level: 'error',
                exception: $e
            )
        );
    }

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function warning(string $message, \Throwable $e): void
    {
        Log::warning(
            message: $message,
            context: ContextBuilder::fromConfig(
                level: 'warning',
                exception: $e
            )
        );
    }

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function notice(string $message, \Throwable $e): void
    {
        Log::notice(
            message: $message,
            context: ContextBuilder::fromConfig(
                level: 'notice',
                exception: $e
            )
        );
    }

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function info(string $message, \Throwable $e): void
    {
        Log::info(
            message: $message,
            context: ContextBuilder::fromConfig(
                level: 'info',
                exception: $e
            )
        );
    }

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function debug(string $message, \Throwable $e): void
    {
        Log::debug(
            message: $message,
            context: ContextBuilder::fromConfig(
                level: 'debug',
                exception: $e
            )
        );
    }
}
