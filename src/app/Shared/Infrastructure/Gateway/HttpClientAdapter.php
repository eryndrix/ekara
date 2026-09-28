<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Gateway;

use Illuminate\Http\Client\Response;
use App\Shared\Domain\Provider\HttpTransportInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Str;

final class HttpClientAdapter implements HttpTransportInterface
{
    /**
     * @phpstan-param PendingRequest $baseRequest
     */
    public function __construct(
        private readonly PendingRequest $baseRequest
    ) {}

    /**
     * @phpstan-param string $method
     * @phpstan-param string $url
     * @phpstan-param array<string, mixed> $queryParams
     * @phpstan-param array<string, mixed> $bodyData
     * @phpstan-param array<string, string> $headers
     *
     * @phpstan-return Response
     *
     * @throws HttpClientException
     */
    public function dispatch(
        string $method,
        string $url,
        array $queryParams = [],
        array $bodyData = [],
        array $headers = []
    ): Response {
        $requestId = Str::uuid()->toString();
        $request = clone $this->baseRequest;

        try {
            $request = $request->withHeaders([
                ...$headers,
                'X-Request-ID' => $requestId,
            ]);

            $httpMethod = strtoupper(string: $method);

            $response = match ($httpMethod) {
                'GET' => $request->get(url: $url, query: $queryParams),
                'POST' => $request->post(url: $url, data: $bodyData),
                'PUT' => $request->put(url: $url, data: $bodyData),
                'DELETE' => $request->delete(url: $url, data: $bodyData),
                default => throw new \InvalidArgumentException(
                    message: 'Unsupported HTTP method: ' . $method
                )
            };

            if ($response->failed()) {
                $body = $response->body();

                throw new HttpClientException(
                    message: sprintf(
                        "API error [%s %s] Status:%d Req-ID:%s\nBody: %s",
                        $method,
                        $url,
                        $response->status(),
                        $requestId,
                        $body === '' ? '(empty)' : $body
                    ),
                    code: $response->status()
                );
            }

            return $response;
        }

        catch (ConnectionException $e) {
            throw new HttpClientException(
                message: sprintf(
                    'Network failure for [%s %s] Req-ID:%s: %s',
                    $method,
                    $url,
                    $requestId,
                    $e->getMessage()
                ),
                previous: $e
            );
        }

        catch (\Throwable $e) {
            throw new HttpClientException(
                message: sprintf(
                    'HTTP client fatal error for [%s %s] Req-ID:%s (%s)',
                    $method,
                    $url,
                    $requestId,
                    $e::class
                ),
                previous: $e
            );
        }
    }
}
