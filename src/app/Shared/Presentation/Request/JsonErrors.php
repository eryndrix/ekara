<?php declare(strict_types=1);

namespace App\Shared\Presentation\Request;

use Illuminate\Contracts\Validation\Validator;
use App\Shared\Presentation\Response\ValidationErrorResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

trait JsonErrors
{
    /**
     * @phpstan-param Validator $validator
     * @phpstan-return void
     */
    protected function failedValidation(Validator $validator): void
    {
        $response = new ValidationErrorResponse(
            errors: $validator->errors()
        );
        
        throw new HttpResponseException(
            response: $response->toResponse(request: $this)
        );
    }
}
