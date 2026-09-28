<?php declare(strict_types=1);

namespace Foundation\Auth\Access;

use Illuminate\Contracts\Auth\Access\Gate;

trait Authorizable
{
    /**
     * @param iterable|\UnitEnum|string $abilities
     * @param mixed $arguments
     * 
     * @return bool
     */
    public function can($abilities, $arguments = []): bool
    {
        return app(
            abstract: Gate::class
        )->forUser(
            user: $this
        )->check(
            abilities: $abilities,
            arguments: $arguments
        );
    }

    /**
     * @param iterable|\UnitEnum|string $abilities
     * @param mixed $arguments
     * 
     * @return bool
     */
    public function canAny($abilities, $arguments = []): bool
    {
        return app(
            abstract: Gate::class
        )->forUser(
            user: $this
        )->any(
            abilities: $abilities,
            arguments: $arguments
        );
    }

    /**
     * @param iterable|\UnitEnum|string $abilities
     * @param mixed $arguments
     * 
     * @return bool
     */
    public function cant($abilities, $arguments = []): bool
    {
        return !$this->can(
            abilities: $abilities,
            arguments: $arguments
        );
    }

    /**
     * @param iterable|\UnitEnum|string $abilities
     * @param mixed $arguments
     * 
     * @return bool
     */
    public function cannot($abilities, $arguments = []): bool
    {
        return $this->cant(
            abilities: $abilities,
            arguments: $arguments
        );
    }
}
