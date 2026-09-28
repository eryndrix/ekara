<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Gateway;

use Illuminate\Support\ServiceProvider;
use App\Shared\Domain\Provider\HttpTransportInterface;
use Illuminate\Support\Facades\Http;

abstract class HttpServiceProvider extends ServiceProvider
{
    /**
     * @phpstan-return string
     */
    abstract protected function service(): string;

    /**
     * @phpstan-return class-string
     */
    abstract protected function contract(): string;

    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $service = $this->service();
        $contract = $this->contract();

        $baseUrl = config(
            key: sprintf('services.%s.base_url', $service)
        );

        if (!is_string(value: $baseUrl) || trim(string: $baseUrl) === '') {
            throw new \RuntimeException(
                message: sprintf(
                    'Missing base URL for configuration key: services.%s.base_url',
                    $service
                )
            );
        }

        /** @phpstan-var int $connectTimeout */
        $connectTimeout = config(
            key: sprintf('services.%s.timeouts.connect', $service),
            default: config(key: 'http_client.timeouts.connect', default: 5)
        );

        /** @phpstan-var int $requestTimeout */
        $requestTimeout = config(
            key: sprintf('services.%s.timeouts.request', $service),
            default: config(key: 'http_client.timeouts.request', default: 15)
        );

        $pendingRequest = Http::baseUrl(url: $baseUrl)
            ->timeout(seconds: $requestTimeout)
            ->connectTimeout(seconds: $connectTimeout)
            ->asJson()
            ->acceptJson();

        $this->app->bind(
            abstract: $contract,
            concrete: fn (): HttpTransportInterface => new HttpClientAdapter(
                baseRequest: $pendingRequest
            )
        );

        $this->initialize();
    }

    /**
     * @phpstan-return void
     */
    abstract protected function initialize(): void;
}
