<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Gateway;

use App\Shared\Domain\Logging\Attribute\{Level, Log};

#[Log(level: Level::ERROR)]
final class HttpClientException extends \RuntimeException
{
    /**
     * @phpstan-param string $message
     * @phpstan-param int $code
     * @phpstan-param \Throwable|null $previous
     */
    public function __construct(
        string $message,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct(
            message: $message,
            code: $code,
            previous: $previous
        );
    }
}
