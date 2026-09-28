<?php declare(strict_types=1);

namespace App\Privilege\Domain;

use Doctrine\ORM\Mapping as ORM;
use App\Shared\Domain\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Privilege\Domain\Relationship\RoleRelationship;
use App\Shared\Domain\Timestamp\CreatedTimestampable;
use App\Shared\Domain\Timestamp\UpdatedTimestampable;
use App\Shared\Domain\Value\Id\RoleId;
use App\Shared\Domain\Value\Slug\RoleSlug;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: '`roles`')]
#[ORM\HasLifecycleCallbacks]
class Role extends AggregateRoot
{
    /**
     * @phpstan-use RoleRelationship<Permission>
     */
    use RoleRelationship;
    
    /**
     * @phpstan-use CreatedTimestampable<\DateTimeImmutable|null>
     */
    use CreatedTimestampable;

    /**
     * @phpstan-use UpdatedTimestampable<\DateTimeImmutable|null>
     */
    use UpdatedTimestampable;
    
    /**
     * @phpstan-var RoleId
     */
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: RoleId::class, unique: true)]
    public private(set) RoleId $id;

    /**
     * @phpstan-var string
     */
    #[ORM\Column(name: 'name', type: Types::STRING, length: 15)]
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
     * @phpstan-var RoleSlug
     */
    #[ORM\Column(name: 'slug', type: RoleSlug::class, unique: true)]
    public private(set) RoleSlug $slug;

    /**
     * @phpstan-var Collection<int, Permission>
     */
    #[ORM\ManyToMany(targetEntity: Permission::class, inversedBy: 'roles')]
    #[ORM\JoinTable(name: 'role_permission')]
    #[ORM\JoinColumn(name: 'role_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'permission_id', referencedColumnName: 'id')]
    public private(set) Collection $permissions;

    /**
     * @phpstan-param string $name
     * @phpstan-param RoleSlug $slug
     * @phpstan-param RoleId|null $id
     */
    public function __construct(
        string $name,
        RoleSlug $slug,
        ?RoleId $id = null,
    ) {
        /**
         * Generates a new RoleId if none is provided.
         */
        $this->id = $id ?? RoleId::generate();

        /**
         * Assigns role data properties.
         */
        $this->name = $name;
        $this->slug = $slug;

        /**
         * Initializes the permissions collection.
         */
        $this->permissions = new ArrayCollection();
        
        /**
         * Initialize created_at and updated_at timestamps.
         */
        $this->initializeCreatedAt();
        $this->initializeUpdatedAt();
    }
}
