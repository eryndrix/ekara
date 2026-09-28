<?php declare(strict_types=1);

namespace App\Account\Domain\Identity\Device;

enum DeviceType: string
{
    /**
     * Desktop device.
     */
    case Desktop = 'desktop';

    /**
     * Mobile phone.
     */
    case Mobile = 'mobile';

    /**
     * Tablet device.
     */
    case Tablet = 'tablet';

    /**
     * Web crawler or bot.
     */
    case Robot = 'robot';

    /**
     * Unrecognized device type.
     */
    case Unknown = 'unknown';

    /**
     * @phpstan-return string
     */
    public function label(): string
    {
        return match($this) {
            self::Desktop => 'Desktop',
            self::Mobile => 'Mobile',
            self::Tablet => 'Tablet',
            self::Robot => 'Robot',
            self::Unknown => 'Unknown',
        };
    }

    /**
     * @phpstan-return bool
     */
    public function isDesktop(): bool
    {
        return $this === self::Desktop;
    }

    /**
     * @phpstan-return bool
     */
    public function isMobile(): bool
    {
        return $this === self::Mobile;
    }

    /**
     * @phpstan-return bool
     */
    public function isTablet(): bool
    {
        return $this === self::Tablet;
    }

    /**
     * @phpstan-return bool
     */
    public function isRobot(): bool
    {
        return $this === self::Robot;
    }

    /**
     * @phpstan-return bool
     */
    public function isUnknown(): bool
    {
        return $this === self::Unknown;
    }
}
