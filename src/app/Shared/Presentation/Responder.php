<?php declare(strict_types=1);

namespace App\Shared\Presentation;

use App\Shared\Presentation\Response\Response;
use App\Shared\Application\Outcome\Result;

/**
 * @phpstan-template TValue
 * @phpstan-template TError
 *
 * @phpstan-method Response respond(Result<TValue, TError> $result)
 */
abstract class Responder
{
	/**
     * @phpstan-param Result<TValue, TError> $result
     * @phpstan-return Response
     */
	abstract public function respond(Result $result): Response;
}
