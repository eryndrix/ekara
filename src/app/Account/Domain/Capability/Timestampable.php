<?php declare(strict_types=1);

namespace App\Account\Domain\Capability;

use App\Shared\Domain\Timestamp\CreatedTimestampable;
use App\Shared\Domain\Timestamp\UpdatedTimestampable;
use App\Shared\Domain\Timestamp\DeletedTimestampable;

trait Timestampable
{
    /**
     * @phpstan-use CreatedTimestampable<\DateTimeImmutable|null>
     */
    use CreatedTimestampable;

    /**
     * @phpstan-use UpdatedTimestampable<\DateTimeImmutable|null>
     */
    use UpdatedTimestampable;

    /**
     * @phpstan-use DeletedTimestampable<\DateTimeImmutable|null>
     */
    use DeletedTimestampable;
}
