<?php declare(strict_types=1);

namespace App\Shared\Domain\Timestamp;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

/**
 * @phpstan-template TDeletedAt as \DateTimeImmutable|null
 */
#[ORM\HasLifecycleCallbacks]
trait DeletedTimestampable
{
    /**
     * @phpstan-var TDeletedAt
     */
    #[ORM\Column(
        name: 'deleted_at',
        type: Types::DATETIME_IMMUTABLE,
        nullable: true
    )]
    public private(set) ?\DateTimeImmutable $deletedAt = null;

    /**
     * @phpstan-return void
     */
    public function softDelete(): void
    {
        $this->deletedAt = new \DateTimeImmutable();
    }

    /**
     * @phpstan-return void
     */
    public function restore(): void
    {
        $this->deletedAt = null;
    }
}
