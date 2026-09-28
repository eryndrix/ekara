<?php declare(strict_types=1);

namespace App\Account\Presentation\Auth\Login;

use App\Shared\Presentation\Request\Request;
use App\Shared\Presentation\Request\JsonErrors;

final class LoginRequest extends Request
{
    /**
     * Enables JSON validation errors.
     */
    use JsonErrors;

    /**
     * @phpstan-return array<string,
     *     \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string
     * >
     */
    public function rules(): array
    {
        return [
            'email' => [
                'bail', 'required', 'email:rfc,strict,spoof', 'max:244', 'exists:users,email'
            ],
            'password' => ['bail', 'required', 'string', 'min:8', 'max:28'],
            'remember_me' => ['bail', 'sometimes', 'boolean'],
        ];
    }

    /**
     * @phpstan-return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(input: [
            'remember_me' => $this->boolean(
                key: 'remember_me',
                default: false
            ),
        ]);
    }
}
