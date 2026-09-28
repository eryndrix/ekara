<?php declare(strict_types=1);

namespace App\Shared\Domain\Logging;

interface LoggerInterface
{
    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function emergency(string $message, \Throwable $e): void;

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function alert(string $message, \Throwable $e): void;

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function critical(string $message, \Throwable $e): void;

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function error(string $message,  \Throwable $e): void;

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function warning(string $message, \Throwable $e): void;

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function notice(string $message, \Throwable $e): void;

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function info(string $message, \Throwable $e): void;

    /**
     * @phpstan-param string $message
     * @phpstan-param \Throwable $e
     *
     * @phpstan-return void
     */
    public function debug(string $message, \Throwable $e): void;
}
