<?php declare(strict_types=1);

namespace App\Shared\Presentation\Response;

use Illuminate\Http\Response as Status;
use Illuminate\Support\MessageBag;

final class ValidationErrorResponse extends ApiResponse
{
    /**
     * @phpstan-param MessageBag $errors
     */
    public function __construct(
        private readonly MessageBag $errors
    ) {
        parent::__construct(
            data: [
                'message' => 'Validation error.',
                'errors' => $errors->getMessages(),
            ],
            status: Status::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
