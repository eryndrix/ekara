<?php declare(strict_types=1);

namespace App\Shared\Presentation\Response;

use Illuminate\Http\Response as Status;
use Illuminate\Http\JsonResponse;

class ApiResponse extends Response
{
    /**
     * @phpstan-param mixed $data
     * @phpstan-param int $status
     */
    public function __construct(
        private readonly mixed $data,
        int $status = Status::HTTP_OK
    ) {
        parent::__construct(status: $status);
    }

    /**
     * @phpstan-param mixed $request
     * @phpstan-return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(data: [
            'status' => $this->status,
            'data' => $this->data,
            'metadata' => $this->metadata()
        ], status: $this->status);
    }
}
