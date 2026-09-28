<?php declare(strict_types=1);

namespace App\Account\Domain;

use Doctrine\ORM\Mapping as ORM;
use App\Shared\Domain\Value\Id\UserId;
use App\Account\Domain\Credential\Email\Email;
use App\Account\Domain\Credential\Phone\Phone;
use App\Account\Domain\Credential\Password\Password;
use App\Account\Domain\Credential\Password\PasswordTrackable;
use App\Shared\Domain\Value\Id\RoleId;
use App\Account\Domain\Capability\UserModifiable;
use App\Account\Domain\Capability\ContactVerifiable;
use App\Account\Domain\Capability\Activatable;
use App\Account\Domain\Capability\Timestampable;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: '`users`')]
#[ORM\HasLifecycleCallbacks]
class User extends AggregateRoot
{
    /**
     * User profile modification capability.
     */
    use UserModifiable;

    /**
     * Contact verification capability (email + phone).
     */
    use ContactVerifiable;

    /**
     * Password change tracking capability.
     */
    use PasswordTrackable;

    /**
     * Activation capability.
     */
    use Activatable;

    /**
     * Timestamp capability (created, updated, deleted).
     */
    use Timestampable;

    /**
     * @phpstan-var UserId
     */
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: UserId::class, unique: true)]
    public private(set) UserId $id;

    /**
     * @phpstan-var Avatar|null
     */
    #[ORM\Column(name: 'avatar', type: Avatar::class, length: 255, nullable: true)]
    public private(set) ?Avatar $avatar = null;

    /**
     * @phpstan-var string
     * 
     * @throws \InvalidArgumentException
     * @throws \DomainException
     */
    #[ORM\Column(name: 'first_name', type: Types::STRING, length: 60)]
    public private(set) string $firstName {
        set (string $value) {
            $value = trim(string: $value);

            if ($value === '') {
                throw new \InvalidArgumentException(
                    message: 'First name cannot be empty.'
                );
            }

            if (mb_strlen(string: $value) > 60) {
                throw new \DomainException(
                    message: 'First name must not exceed 60 characters.'
                );
            }

            $this->firstName = mb_convert_case(
                string: $value,
                mode: MB_CASE_TITLE,
                encoding: 'UTF-8'
            );
        }
    }

    /**
     * @phpstan-var string
     * 
     * @throws \InvalidArgumentException
     * @throws \DomainException
     */
    #[ORM\Column(name: 'last_name', type: Types::STRING, length: 80)]
    public private(set) string $lastName {
        set (string $value) {
            $value = trim(string: $value);

            if ($value === '') {
                throw new \InvalidArgumentException(
                    message: 'Last name cannot be empty.'
                );
            }

            if (mb_strlen(string: $value) > 80) {
                throw new \DomainException(
                    message: 'Last name must not exceed 80 characters.'
                );
            }

            $this->lastName = mb_convert_case(
                string: $value,
                mode: MB_CASE_TITLE,
                encoding: 'UTF-8'
            );
        }
    }

    /**
     * @phpstan-var Email
     */
    #[ORM\Embedded(class: Email::class, columnPrefix: false)]
    public private(set) Email $email;

    /**
     * @phpstan-var \DateTimeImmutable|null
     */
    #[ORM\Column(
        name: 'email_verified_at',
        type: Types::DATETIME_IMMUTABLE,
        nullable: true
    )]
    public private(set) ?\DateTimeImmutable $emailVerifiedAt = null;

    /**
     * @phpstan-var Phone|null
     */
    #[ORM\Column(name: 'phone', type: Phone::class, length: 20, unique: true, nullable: true)]
    public private(set) ?Phone $phone = null;

    /**
     * @phpstan-var \DateTimeImmutable|null
     */
    #[ORM\Column(
        name: 'phone_verified_at',
        type: Types::DATETIME_IMMUTABLE,
        precision: 6,
        nullable: true
    )]
    private ?\DateTimeImmutable $phoneVerifiedAt = null;

    /**
     * @phpstan-var Password
     */
    #[ORM\Embedded(class: Password::class, columnPrefix: false)]
    protected Password $password;

    /**
     * @phpstan-var \DateTimeImmutable|null
     */
    #[ORM\Column(
        name: 'password_changed_at',
        type: Types::DATETIME_IMMUTABLE,
        precision: 6,
        nullable: true
    )]
    private ?\DateTimeImmutable $passwordChangedAt = null;

    /**
     * @phpstan-var string|null
     * @throws \DomainException
     */
    #[ORM\Column(name: 'bio', type: Types::STRING, length: 255, nullable: true)]
    public private(set) ?string $bio = null {
        set (string|null $value) {
            if ($value === null || $value === '') {
                $bio = null;
            } else {
                $bio = trim(string: $value);
            }

            if ($this->bio === $bio) {
                return;
            }

            if ($bio !== null && mb_strlen(string: $bio) > 255) {
                throw new \DomainException(
                    message: 'Biography must not exceed 255 characters.'
                );
            }

            $this->bio = $bio;
        }
    }

    /**
     * @phpstan-var bool
     */
    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN, options: ['default' => true])]
    public private(set) bool $isActive = true;

    /**
     * @phpstan-var string|null
     * @throws \DomainException
     */
    #[ORM\Column(
        name: 'remember_token',
        type: Types::STRING,
        length: 100,
        unique: true,
        nullable: true
    )]
    protected ?string $rememberToken = null {
        set (string|null $value) {
            if ($value === null) {
                $this->rememberToken = null;
                return;
            }

            $rememberToken = trim(string: $value);

            if ($rememberToken === '') {
                throw new \DomainException(
                    message: 'Remember token cannot be empty.'
                );
            }

            if (mb_strlen(string: $rememberToken) > 100) {
                throw new \DomainException(
                    message: 'Remember token is too long.'
                );
            }

            $this->rememberToken = $rememberToken;
        }
    }

    /**
     * @phpstan-var RoleId
     */
    #[ORM\Column(name: 'role_id', type: RoleId::class)]
    public private(set) RoleId $roleId;

    /**
     * @phpstan-param string $firstName
     * @phpstan-param string $lastName
     * @phpstan-param Email $email
     * @phpstan-param Password $password
     * @phpstan-param RoleId $roleId
     * @phpstan-param Avatar|null $avatar
     * @phpstan-param string|null $bio
     * @phpstan-param Phone|null $phone
     * @phpstan-param UserId|null $id
     */
    public function __construct(
        string $firstName,
        string $lastName,
        Email $email,
        Password $password,
        RoleId $roleId,
        ?Avatar $avatar = null,
        ?string $bio = null,
        ?Phone $phone = null,
        ?UserId $id = null
    ) {
        /**
         * Generates a new UserId if none is provided.
         */
        $this->id = $id ?? UserId::generate();

        /**
         * Assigns user data properties.
         */
        $this->avatar = $avatar;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->bio = $bio;
        $this->password = $password;
        $this->roleId = $roleId;
        
        /**
         * Initialize created_at and updated_at timestamps.
         */
        $this->initializeCreatedAt();
        $this->initializeUpdatedAt();
    }
}
