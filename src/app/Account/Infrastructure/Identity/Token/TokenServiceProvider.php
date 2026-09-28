<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Identity\Token;

use App\Account\Domain\Identity\Token\TokenExpirationInterface;
use Illuminate\Support\ServiceProvider;

final class TokenServiceProvider extends ServiceProvider
{
    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $this->app->bind(
            abstract: TokenExpirationInterface::class,
            concrete: ConfigTokenTtlProvider::class
        );
    }
}
