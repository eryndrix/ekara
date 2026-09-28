<?php declare(strict_types=1);

namespace App\Account\Presentation\Auth\Login;

use App\Shared\Presentation\Controller;
use App\Account\Application\Command\LoginCommand;
use App\Shared\Domain\Bus\CommandBusInterface;
use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use App\Shared\Presentation\Response\ApiResponse;
use App\Shared\Application\Outcome\Result;

#[Prefix(prefix: 'v1')]
//#[Middleware(middleware: ['guest', 'throttle:3,5'])]
final class LoginController extends Controller
{
    /**
     * @phpstan-var LoginResponder
     */
    private readonly LoginResponder $responder;

    /**
     * @phpstan-param CommandBusInterface $commandBus
     */
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
        $this->responder = new LoginResponder();
    }

    /**
     * @phpstan-param LoginRequest $request
     * @phpstan-return ApiResponse
     */
    #[Route(methods: 'POST', uri: '/login')]
    public function __invoke(LoginRequest $request): ApiResponse
    {
        /**
         * @phpstan-var Result<
         *     \App\Shared\Application\Payload\Envelope<
         *         \App\Account\Application\TokenData
         *     >, \Throwable
         * > $result
         */
        $result = $this->commandBus->send(
            command: LoginCommand::fromRequest(
                request: $request
            )
        );

        return $this->responder->respond(result: $result);
    }
}
