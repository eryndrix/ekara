<?php declare(strict_types=1);

namespace App\Account\Domain\Capability;

/**
 * @phpstan-require-extends \App\Account\Domain\User
 */
trait Activatable
{
    /**
     * @phpstan-var non-empty-string
     */
    private const string IS_ACTIVE = 'isActive';

    /**
     * @phpstan-return void
     */
    public function activate(): void
    {
        if ($this->{self::IS_ACTIVE}) {
            return;
        }

        $this->{self::IS_ACTIVE} = true;
    }

    /**
     * @phpstan-return void
     */
    public function deactivate(): void
    {
        if (!$this->{self::IS_ACTIVE}) {
            return;
        }

        $this->{self::IS_ACTIVE} = false;
    }
}
