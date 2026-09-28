<?php declare(strict_types=1);

namespace App\Account\Application\Exception;

use App\Shared\Domain\Logging\Attribute\{Level, Log};

#[Log(level: Level::WARNING)]
final class InvalidCredentialsException extends \LogicException
{
    /**
     * @phpstan-param string $message
     * @phpstan-param int $code
     * @phpstan-param \Throwable|null $previous
     */
    public function __construct(
        string $message = 'Invalid credentials.',
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
