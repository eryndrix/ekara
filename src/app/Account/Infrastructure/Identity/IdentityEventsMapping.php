<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Identity;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

final class IdentityEventsMapping extends EventServiceProvider
{
    /**
     * @phpstan-var array<string, array<int, string>>
     */
    protected $listen = [];

    /**
     * @phpstan-return void
     */
    public function boot(): void
    {
        parent::boot();
    }
}
