<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Identity\Device;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Jenssegers\Agent\Agent;
use App\Account\Domain\Identity\Device\DeviceResolverInterface;
use App\Account\Domain\Identity\Device\UserAgentInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

final class DeviceServiceProvider extends ServiceProvider
    implements DeferrableProvider
{
    /**
     * @phpstan-return void
     */
    public function register(): void
    {
        $this->app->bind(
            abstract: Agent::class,
            concrete: static function (Application $app): Agent {
                /** @phpstan-var Request $request */
                $request = $app->make(abstract: 'request');
                return new Agent(userAgent: $request->userAgent());
            }
        );

        $this->app->bind(
            abstract: UserAgentInterface::class,
            concrete: JenssegersUserAgent::class
        );

        $this->app->bind(
            abstract: DeviceResolverInterface::class,
            concrete: static function (Application $app): JenssegersDeviceResolver {
                return new JenssegersDeviceResolver(
                    userAgent: $app->make(abstract: UserAgentInterface::class),
                    rules: [
                        $app->make(abstract: RobotDeviceNameRule::class),
                        $app->make(abstract: MobileDeviceNameRule::class),
                        $app->make(abstract: DesktopDeviceNameRule::class),
                    ]
                );
            }
        );
    }

    /**
     * @phpstan-return array<int, class-string>
     */
    public function provides(): array
    {
        return [
            Agent::class,
            UserAgentInterface::class,
            DeviceResolverInterface::class,
        ];
    }
}
