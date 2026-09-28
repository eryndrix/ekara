<?php declare(strict_types=1);

namespace App\Shared\Presentation\Response;

use Illuminate\Http\Response as Status;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Context;

abstract class Response implements Responsable
{
    /**
     * @phpstan-param int $status
     */
    public function __construct(
        public private(set) int $status = Status::HTTP_OK
    ) {}

    /**
     * @phpstan-return array<string, mixed>
     */
    public function metadata(): array
    {
        $requestId = Context::get(key: 'request_id');
        $timestamp = Context::get(key: 'timestamp');

        return [
            'request_id' => $requestId,
            'timestamp' => $timestamp
        ];
    }
}
