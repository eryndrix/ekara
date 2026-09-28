<?php declare(strict_types=1);

namespace App\Privilege\Domain\Repository;

use App\Shared\Domain\Value\{Slug\RoleSlug, Id\RoleId};
use App\Shared\Domain\Repository\RoleRepositoryInterface as RepositoryInterface;
use App\Privilege\Domain\Role;

interface RoleRepositoryInterface extends RepositoryInterface
{
    /**
     * @phpstan-param int $perPage
     * @phpstan-return iterable<Role>
     */
    public function paginate(int $perPage = 15): iterable;

    /**
     * @phpstan-param RoleId $id
     * @phpstan-return Role|null
     */
    public function findById(RoleId $id): ?Role;

    /**
     * @phpstan-param RoleSlug $slug
     * @phpstan-return Role|null
     */
    public function findBySlug(RoleSlug $slug): ?Role;
}
