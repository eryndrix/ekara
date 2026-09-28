<?php declare(strict_types=1);

namespace App\Account\Application\Outcome;

use App\Shared\Application\Payload\Envelope;
use App\Account\Application\Context\LoginContext;
use App\Account\Application\TokenData;

final class LoginOutcome
{
    /**
     * @phpstan-param LoginContext $context
     * @phpstan-return Envelope<TokenData>
     */
    public function form(LoginContext $context): Envelope
    {
        $data = new TokenData(
            accessToken: (string) $context->token,
            expiresAt: $context->expiresAt
        );

        return Envelope::with(data: $data);
    }
}
