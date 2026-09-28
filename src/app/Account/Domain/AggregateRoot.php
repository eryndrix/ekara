<?php declare(strict_types=1);

namespace App\Account\Domain;

use Doctrine\ORM\Mapping as ORM;
use App\Account\Domain\Identity\Authenticatable;
use App\Shared\Domain\Event\EventRecordable;

#[ORM\MappedSuperclass]
abstract class AggregateRoot extends Authenticatable
{
    /**
     * Domain event recording capability.
     */
    use EventRecordable;
}
