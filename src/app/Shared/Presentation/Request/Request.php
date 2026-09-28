<?php declare(strict_types=1);

namespace App\Shared\Presentation\Request;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * @phpstan-return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @phpstan-return array<string,
     *     \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string
     * >
     */
    abstract public function rules(): array;
}
