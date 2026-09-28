<?php declare(strict_types=1);

namespace Foundation\Auth\Sanctum;

use Illuminate\Auth\AuthManager;
use Illuminate\Auth\RequestGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

final class SanctumConnector extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        /** @var AuthManager $auth */
        $auth = $this->app->make(abstract: 'auth');

        $auth->extend(
            driver: 'sanctum',
            callback: function (
                Application $app,
                string $name,
                array $config
            ) use ($auth): RequestGuard {
                /** @var string|null $provider */
                $provider = $config['provider'] ?? null;

                /** @var int|null $expiration */
                $expiration = config(
                    key: 'sanctum.expiration',
                    default: null
                );

                if ($expiration !== null) {
                    $expiration = (int) $expiration;
                }

                $trackLastUsedAt = (bool) config(
                    key: 'sanctum.track_last_used_at',
                    default: true
                );

                /** @var Request $request */
                $request = $app['request'];

                return new RequestGuard(
                    callback: new Guard(
                        auth: $auth,
                        expiration: $expiration,
                        provider: $provider,
                        trackLastUsedAt: $trackLastUsedAt
                    ),
                    request: $request,
                    provider: $auth->createUserProvider(
                        provider: $provider
                    )
                );
            }
        );

        $this->app->booted(
            callback: function (): void {
                Sanctum::usePersonalAccessTokenModel(
                    model: Token::class
                );
            }
        );
    }
}
