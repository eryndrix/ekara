<?php declare(strict_types=1);

namespace App\Shared\Application\Exception;

use App\Shared\Domain\Logging\Attribute\{Level, Log};

#[Log(level: Level::WARNING)]
final class UserNotFoundException extends \LogicException
{
    /**
     * @phpstan-param string $message
     * @phpstan-param int $code
     * @phpstan-param \Throwable|null $previous
     */
    public function __construct(
        string $message = 'User must not be null.',
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
