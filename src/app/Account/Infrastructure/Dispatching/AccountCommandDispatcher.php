<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Dispatching;

use Illuminate\Support\ServiceProvider;
use App\Account\Application\Command\LoginCommand;
use App\Account\Application\Handler\LoginHandler;
use App\Shared\Domain\Bus\CommandBusInterface;

final class AccountCommandDispatcher extends ServiceProvider
{
    /**
     * @phpstan-var array<
     *     class-string<\App\Shared\Application\Payload\Command>,
     *     class-string<\App\Shared\Application\Handler>
     * >
     */
    private array $auth = [
        LoginCommand::class => LoginHandler::class,
    ];

    /**
     * @phpstan-param CommandBusInterface $commandBus
     * @phpstan-return void
     */
    public function boot(CommandBusInterface $commandBus): void
    {
        $commandBus->register(map: [
            ...$this->auth,
        ]);
    }
}
