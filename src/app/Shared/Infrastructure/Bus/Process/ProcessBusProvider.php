<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Process;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Shared\Domain\Bus\ProcessBusInterface;

final class ProcessBusProvider extends ServiceProvider
    implements DeferrableProvider
{
    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: ProcessBusInterface::class,
            concrete: ProcessBus::class
        );
    }

    /**
     * @phpstan-return array<int, class-string>
     */
    public function provides(): array
    {
        return [ProcessBusInterface::class];
    }
}
