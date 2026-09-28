<?php declare(strict_types=1);

namespace App\Privilege\Domain;

use Doctrine\ORM\Mapping as ORM;
use App\Shared\Domain\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Privilege\Domain\Relationship\PermissionRelationship;
use App\Shared\Domain\Timestamp\CreatedTimestampable;
use App\Shared\Domain\Timestamp\UpdatedTimestampable;
use App\Shared\Domain\Value\Id\PermissionId;
use App\Shared\Domain\Value\Slug\PermissionSlug;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: '`permissions`')]
#[ORM\HasLifecycleCallbacks]
class Permission extends AggregateRoot
{
    /**
     * @phpstan-use PermissionRelationship<Role>
     */
    use PermissionRelationship;

    /**
     * @phpstan-use CreatedTimestampable<\DateTimeImmutable|null>
     */
    use CreatedTimestampable;

    /**
     * @phpstan-use UpdatedTimestampable<\DateTimeImmutable|null>
     */
    use UpdatedTimestampable;

    /**
     * @phpstan-var PermissionId
     */
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: PermissionId::class, unique: true)]
    public private(set) PermissionId $id;

    /**
     * @phpstan-var string
     */
    #[ORM\Column(name: 'name', type: Types::STRING, length: 45)]
    public private(set) string $name {
        set (string $value) {
            $this->name = $value
                |> trim(...)
                |> (fn (string $name): string => mb_convert_case(
                    string: $name,
                    mode: MB_CASE_TITLE,
                    encoding: 'UTF-8'
                ));
        }
    }

    /**
     * @phpstan-var PermissionSlug
     */
    #[ORM\Column(name: 'slug', type: PermissionSlug::class, unique: true)]
    public private(set) PermissionSlug $slug;

    /**
     * @phpstan-var Guard
     */
    #[ORM\Column(name: 'guard', type: Types::ENUM, enumType: Guard::class)]
    public private(set) Guard $guard;

    /**
     * @phpstan-var Collection<int, Role>
     */
    #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: 'permissions')]
    public private(set) Collection $roles;

    /**
     * @phpstan-param string $name
     * @phpstan-param PermissionSlug $slug
     * @phpstan-param Guard $guard
     * @phpstan-param PermissionId|null $id
     */
    public function __construct(
        string $name,
        PermissionSlug $slug,
        Guard $guard,
        ?PermissionId $id = null,
    ) {
        $this->id = $id ?? PermissionId::generate();

        /**
         * Assigns permission data properties.
         */
        $this->name = $name;
        $this->slug = $slug;
        $this->guard = $guard;

        /**
         * Initializes the roles collection.
         */
        $this->roles = new ArrayCollection();

        /**
         * Initialize created_at and updated_at timestamps.
         */
        $this->initializeCreatedAt();
        $this->initializeUpdatedAt();
    }
}
