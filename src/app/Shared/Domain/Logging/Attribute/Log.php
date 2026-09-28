<?php declare(strict_types=1);

namespace App\Shared\Domain\Logging\Attribute;

#[\Attribute(flags: \Attribute::TARGET_CLASS)]
final readonly class Log
{
    /**
     * @phpstan-param Level $level
     */
    public function __construct(
        public private(set) Level $level
    ) {}
}
