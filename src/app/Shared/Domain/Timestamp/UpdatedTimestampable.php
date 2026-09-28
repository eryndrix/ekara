<?php declare(strict_types=1);

namespace App\Shared\Domain\Timestamp;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

/**
 * @phpstan-template TUpdatedAt as \DateTimeImmutable|null
 */
#[ORM\HasLifecycleCallbacks]
trait UpdatedTimestampable
{
    /**
     * @phpstan-var TUpdatedAt
     */
    #[ORM\Column(
        name: 'updated_at',
        type: Types::DATETIME_IMMUTABLE, options: [
            'precision' => 6
        ],
        nullable: true
    )]
    public private(set) ?\DateTimeImmutable $updatedAt = null;

    /**
     * @phpstan-var bool
     */
    private bool $skipUpdatedAtForNextFlush = false;
    
    /**
     * @phpstan-return void
     */
    #[ORM\PreUpdate]
    public function initializeUpdatedAt(): void
    {
        if ($this->skipUpdatedAtForNextFlush) {
            $this->skipUpdatedAtForNextFlush = false;
            return;
        }

        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @phpstan-return void
     */
    public function skipUpdatedAt(): void
    {
        $this->skipUpdatedAtForNextFlush = true;
    }
}
