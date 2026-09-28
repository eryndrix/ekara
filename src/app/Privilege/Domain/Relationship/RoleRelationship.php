<?php declare(strict_types=1);

namespace App\Privilege\Domain\Relationship;

use App\Privilege\Domain\Permission;
use App\Shared\Domain\Value\Id\PermissionId;

/**
 * @phpstan-template TPermission of Permission
 */
trait RoleRelationship
{
    /**
     * @phpstan-param TPermission $permission
     * @phpstan-return void
     */
    public function assignPermission(Permission $permission): void
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions->add($permission);
            $permission->assignRole(role: $this);
        }
    }

    /**
     * @phpstan-param TPermission $permission
     * @phpstan-return void
     */
    public function removePermission(Permission $permission): void
    {
        if ($this->permissions->removeElement($permission)) {
            $permission->removeRole(role: $this);
        }
    }

    /**
     * @phpstan-param TPermission $permission
     * @phpstan-return bool
     */
    public function hasPermission(Permission $permission): bool
    {
        return $this->permissions->contains($permission);
    }

    /**
     * @phpstan-param string $permissionId
     * @phpstan-return bool
     */
    public function hasPermissionId(string $permissionId): bool
    {
        return $this->permissions->exists(
            p: fn (int $index, Permission $permission) =>
                $permission->id->equals(
                    other: PermissionId::of(value: $permissionId)
                )
        );
    }
    
    /**
     * @phpstan-return void
     */
    public function clearPermissions(): void
    {
        foreach ($this->permissions as $permission) {
            $this->removePermission(permission: $permission);
        }
    }
}
