<?php declare(strict_types=1);

namespace App\Shared\Domain\Provider;

use Illuminate\Http\Client\Response;

interface HttpTransportInterface
{
    /**
     * @phpstan-param string $method
     * @phpstan-param string $url
     * @phpstan-param array<string, mixed> $queryParams
     * @phpstan-param array<string, mixed> $bodyData
     * @phpstan-param array<string, string> $headers
     *
     * @phpstan-return Response
     */
    public function dispatch(
        string $method,
        string $url,
        array $queryParams = [],
        array $bodyData = [],
        array $headers = []
    ): Response;
}
