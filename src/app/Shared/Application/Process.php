<?php declare(strict_types=1);

namespace App\Shared\Application;

/**
 * @phpstan-template TContext of Context
 * @phpstan-template-covariant TResult
 */
abstract class Process
{
    /**
     * @phpstan-var TContext
     */
    public protected(set) Context $context;

    /**
     * @phpstan-var list<class-string<Action>>
     */
    public protected(set) array $workflow = [];

    /**
     * @phpstan-param class-string<Action> $action
     * @phpstan-return void
     */
    protected function add(string $action): void
    {
        $this->workflow[] = $action;
    }
}
