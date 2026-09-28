<?php declare(strict_types=1);

namespace App\Shared\Domain\Provider;

/**
 * @phpstan-template TResult
 */
interface UnitOfWorkInterface
{
    /**
     * @phpstan-return void
     */
    public function flush(): void;

    /**
     * @phpstan-param callable():TResult $callback
     * @phpstan-return TResult
     */
    public function transactional(callable $callback): mixed;
}
