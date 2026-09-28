<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use App\Shared\Domain\Provider\UnitOfWorkInterface;
use Doctrine\DBAL\Connection;

/**
 * @phpstan-implements UnitOfWorkInterface<mixed>
 */
final class DoctrineUnitOfWork implements UnitOfWorkInterface
{
    /**
     * @phpstan-param EntityManagerInterface $entityManager
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    /**
     * @phpstan-return void
     * @throws \Throwable
     */
    public function flush(): void
    {
        try {
            $this->entityManager->flush();
        }

        catch (\Throwable $e) {
            $this->entityManager->clear();
            throw $e;
        }
    }

    /**
     * @phpstan-param callable():mixed $callback
     * @phpstan-return mixed
     * 
     * @throws \Throwable
     */
    public function transactional(callable $callback): mixed
    {
        return $this->entityManager->wrapInTransaction(
            func: function () use ($callback): mixed {
                try {
                    return $callback();
                }

                catch (\Throwable $e) {
                    $this->entityManager->clear();
                    throw $e;
                }
            }
        );
    }

    /**
     * @phpstan-return Connection
     */
    public function getConnection(): Connection
    {
        return $this->entityManager->getConnection();
    }

    /**
     * @phpstan-return void
     */
    public function clear(): void
    {
        $this->entityManager->clear();
    }
}
