<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Persistence;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

final class AccountRepositoryBinder extends ServiceProvider
    implements DeferrableProvider
{
    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $this->app->bind(
            abstract: \App\Account\Domain\Repository\UserRepositoryInterface::class,
            concrete: UserRepository::class
        );

        $this->app->bind(
            abstract: \App\Shared\Domain\Repository\UserRepositoryInterface::class,
            concrete: UserRepository::class
        );
    }

    /**
     * @phpstan-return array<int, class-string>
     */
    public function provides(): array
    {
        return [
            \App\Account\Domain\Repository\UserRepositoryInterface::class,
            \App\Shared\Domain\Repository\UserRepositoryInterface::class
        ];
    }
}
