<?php declare(strict_types=1);

namespace App\Account\Presentation\Auth\Login;

use App\Shared\Presentation\Responder;
use App\Shared\Presentation\Response\ApiResponse;
use Illuminate\Http\Response as Status;
use App\Shared\Application\Exception\UserNotFoundException;
use App\Account\Application\Exception\InvalidCredentialsException;
use App\Shared\Application\Outcome\Result;
use App\Shared\Application\Payload\Envelope;
use App\Account\Application\TokenData;

/**
 * @phpstan-extends Responder<Envelope<TokenData>, \Throwable>
 */
final class LoginResponder extends Responder
{
    /**
     * @phpstan-param Result<Envelope<TokenData>, \Throwable> $result
     * @phpstan-return ApiResponse
     */
    public function respond(Result $result): ApiResponse
    {
        return $result->match(
            onSuccess: function (Envelope $envelope): ApiResponse {
                return new ApiResponse(
                    data: new TokenResource(resource: $envelope->data),
                    status: Status::HTTP_OK
                );
            },
            onError: fn (\Throwable $e) => match (true) {
                $e instanceof \DomainException => new ApiResponse(
                    data: ['message' => $e->getMessage()],
                    status: Status::HTTP_BAD_REQUEST
                ),
                $e instanceof InvalidCredentialsException,
                $e instanceof UserNotFoundException => new ApiResponse(
                    data: ['message' => 'Invalid credentials.'],
                    status: Status::HTTP_UNAUTHORIZED
                ),
                default => new ApiResponse(
                    data: ['message' => 'An error occurred during login.'],
                    status: Status::HTTP_INTERNAL_SERVER_ERROR
                ),
            }
        );
    }
}
