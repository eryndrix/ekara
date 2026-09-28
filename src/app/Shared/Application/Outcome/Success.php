<?php declare(strict_types=1);

namespace App\Shared\Application\Outcome;

/**
 * @phpstan-template TSuccess
 * @phpstan-extends Result<TSuccess, never>
 */
final class Success extends Result
{
    /**
     * @phpstan-param TSuccess $value
     */
    public function __construct(mixed $value)
    {
        parent::__construct(value: $value);
    }
    
    /**
     * @phpstan-return bool
     */
    public function isSuccess(): bool
    {
        return true;
    }
}
