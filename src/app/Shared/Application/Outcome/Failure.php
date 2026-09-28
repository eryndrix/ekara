<?php declare(strict_types=1);

namespace App\Shared\Application\Outcome;

/**
 * @phpstan-template TFailure
 * @phpstan-extends Result<never, TFailure>
 */
final class Failure extends Result
{
    /**
     * @phpstan-param TFailure $error
     */
    public function __construct(mixed $error)
    {
        parent::__construct(error: $error);
    }

    /**
     * @phpstan-return bool
     */
    public function isSuccess(): bool
    {
        return false;
    }
}
