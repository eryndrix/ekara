<?php declare(strict_types=1);

namespace App\Account\Application\Command;

use App\Shared\Application\Payload\Command;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\Attributes\Cast;

final class RegisterCommand extends Command
{
    /**
     * @phpstan-var string
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $firstName;

    /**
     * @phpstan-var string
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $lastName;

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
     * @phpstan-return array<string, string>
     */
    protected function mapData(): array
    {
        return [
            'first_name' => 'firstName',
            'last_name' => 'lastName'
        ];
    }
}
