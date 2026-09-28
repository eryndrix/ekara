<?php declare(strict_types=1);

namespace App\Account\Presentation\Auth\Login;

use App\Account\Application\TokenData;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @mixin TokenData
 */
final class TokenResource extends JsonResource
{
    /**
     * @phpstan-param Request $request
     * @phpstan-return array{
     *     access_token: string,
     *     token_type: string,
     *     expires_in?: int,
     *     expires_at?: string
     * }
     */
    public function toArray(Request $request): array
    {
        /** @phpstan-var TokenData $data */
        $data = $this->resource;

        $body = [
            'access_token' => $data->accessToken,
            'token_type' => 'Bearer',
        ];

        if ($data->expiresAt !== null) {
            $body['expires_in'] = $data->expiresAt->getTimestamp()
                - new \DateTimeImmutable()->getTimestamp();

            $body['expires_at'] = $data->expiresAt->format(
                format: \DateTimeInterface::ATOM
            );
        }

        return $body;
    }
}
