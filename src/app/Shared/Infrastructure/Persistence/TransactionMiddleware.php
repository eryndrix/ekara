<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence;

use App\Shared\Domain\Provider\UnitOfWorkInterface;

final class TransactionMiddleware
{
    /**
     * @phpstan-param UnitOfWorkInterface<mixed> $unitOfWork
     */
    public function __construct(
        private readonly UnitOfWorkInterface $unitOfWork
    ) {}

    /**
     * @phpstan-param object $command
     * @phpstan-param \Closure(object):mixed $next
     *
     * @phpstan-return mixed
     */
    public function handle(object $command, \Closure $next): mixed
    {
        return $this->unitOfWork->transactional(
            callback: fn(): mixed => $next($command)
        );
    }
}
