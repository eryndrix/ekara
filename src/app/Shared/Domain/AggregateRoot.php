<?php declare(strict_types=1);

namespace App\Shared\Domain;

use Doctrine\ORM\Mapping as ORM;
use App\Shared\Domain\Event\EventRecordable;

#[ORM\MappedSuperclass]
abstract class AggregateRoot
{
    /**
     * Domain event recording capability.
     */
    use EventRecordable;
}
