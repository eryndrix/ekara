<?php declare(strict_types=1);

namespace App\Account\Application\Command;

use App\Shared\Application\Payload\Command;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\Casting\BooleanCast;
use WendellAdriel\ValidatedDTO\Attributes\Cast;

final class LoginCommand extends Command
{
    /**
     * @phpstan-var string
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $email;

    /**
     * @phpstan-var string
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $password;

    /**
     * @phpstan-var bool
     */
    #[Cast(type: BooleanCast::class, param: null)]
    public bool $rememberMe = false;

    /**
     * @phpstan-return array<string, string>
     */
    protected function mapData(): array
    {
        return [
            'remember_me' => 'rememberMe',
        ];
    }
}
