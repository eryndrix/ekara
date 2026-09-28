<?php declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use App\Shared\Domain\Logging\Attribute\{Level, Log};

#[Log(level: Level::WARNING)]
final class PaginationException extends \DomainException
{
    /**
     * @phpstan-var int
     */
    private const int MIN_PER_PAGE = 1;
    
    /**
     * @phpstan-var int
     */
    private const int MAX_PER_PAGE = 100;

    /**
     * @phpstan-param int $perPage
     * @phpstan-param string $message
     * @phpstan-param int $code
     * @phpstan-param \Throwable|null $previous
     */
    public function __construct(
        int $perPage,
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        if ($message === '') {
            $message = sprintf(
                'Per page must be between %d and %d. Given: %d.',
                self::MIN_PER_PAGE,
                self::MAX_PER_PAGE,
                $perPage
            );
        }

        parent::__construct(
            message: $message,
            code: $code,
            previous: $previous
        );
    }
}
