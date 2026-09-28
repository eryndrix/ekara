<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Clock;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Shared\Domain\Criterion\ClockInterface;

final class ClockRegistrar extends ServiceProvider
    implements DeferrableProvider
{
    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: ClockInterface::class,
            concrete: SystemClock::class
        );
    }

    /**
     * @phpstan-return array<int, class-string>
     */
    public function provides(): array
    {
        return [
            ClockInterface::class
        ];
    }
}
