<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Shared\Domain\Provider\UnitOfWorkInterface;

final class UnitOfWorkProvider extends ServiceProvider
    implements DeferrableProvider
{
    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: UnitOfWorkInterface::class,
            concrete: DoctrineUnitOfWork::class
        );
    }

    /**
     * @phpstan-return array<int, class-string>
     */
    public function provides(): array
    {
        return [UnitOfWorkInterface::class];
    }
}
