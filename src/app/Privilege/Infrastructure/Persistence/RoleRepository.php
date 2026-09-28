<?php declare(strict_types=1);

namespace App\Privilege\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use App\Privilege\Domain\Repository\RoleRepositoryInterface;
use App\Shared\Domain\Value\{Slug\RoleSlug, Id\RoleId};
use Foundation\Doctrine\Pagination\LengthAwarePaginator;
use App\Privilege\Domain\Role;

final class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @phpstan-param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @phpstan-param int $perPage
     * @phpstan-return iterable<Role>
     */
    public function paginate(int $perPage = 15): iterable
    {
        $qb = $this->entityManager->createQueryBuilder();

        $result = $qb->select('r', 'p')
            ->from(from: Role::class, alias: 'r')
            ->leftJoin('r.permissions', 'p') 
            ->addSelect('p')
            ->orderBy(sort: 'r.createdAt', order: 'ASC')
            ->getQuery();

        /** @phpstan-var LengthAwarePaginator<Role> */
        return new LengthAwarePaginator(
            query: $result,
            perPage: $perPage
        );
    }

    /**
     * @phpstan-param RoleId $id
     * @phpstan-return Role|null
     */
    public function findById(RoleId $id): ?Role
    {
        $qb = $this->entityManager->createQueryBuilder();

        /** @phpstan-var Role|null $result */
        $result = $qb->select('r')
            ->from(from: Role::class, alias: 'r')
            ->where('r.id = :id')
            ->setParameter(key: 'id', value: $id)
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }

    /**
     * @phpstan-param RoleSlug $slug
     * @phpstan-return Role|null
     */
    public function findBySlug(RoleSlug $slug): ?Role
    {
        $qb = $this->entityManager->createQueryBuilder();

        /** @phpstan-var Role|null $result */
        $result = $qb->select('r')
            ->from(from: Role::class, alias: 'r')
            ->where('r.slug = :slug')
            ->setParameter(key: 'slug', value: $slug)
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }
}
