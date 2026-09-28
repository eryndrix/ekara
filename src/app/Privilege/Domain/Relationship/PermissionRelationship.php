<?php declare(strict_types=1);

namespace App\Privilege\Domain\Relationship;

use App\Privilege\Domain\Role;
use App\Shared\Domain\Value\Id\RoleId;

/**
 * @phpstan-template TRole of Role
 */
trait PermissionRelationship
{
    /**
     * @phpstan-param TRole $role
     * @phpstan-return void
     */
    public function assignRole(Role $role): void
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->assignPermission(permission: $this);
        }
    }

    /**
     * @phpstan-param TRole $role
     * @phpstan-return void
     */
    public function removeRole(Role $role): void
    {
        if ($this->roles->removeElement($role)) {
            $role->removePermission(permission: $this);
        }
    }

    /**
     * @phpstan-return void
     */
    public function clearRoles(): void
    {
        foreach ($this->roles as $role) {
            $this->removeRole(role: $role);
        }
    }

    /**
     * @phpstan-param TRole $role
     * @phpstan-return bool
     */
    public function hasRole(Role $role): bool
    {
        return $this->roles->contains($role);
    }

    /**
     * @phpstan-param string $roleId
     * @phpstan-return bool
     */
    public function hasRoleId(string $roleId): bool
    {
        return $this->roles->exists(
            p: fn (int $index, Role $role) =>
                $role->id->equals(
                    other: RoleId::of(value: $roleId)
                )
        );
    }
}
