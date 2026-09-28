<?php declare(strict_types=1);

namespace Foundation\Auth\Sanctum;

use Doctrine\ORM\EntityManagerInterface;
use Foundation\Auth\UserProviderInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

final class Token extends PersonalAccessToken
{
    use HasUuids;

    /**
     * @var string
     */
    protected $table = 'personal_access_tokens';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
    ];

    /**
     * @return string
     */
    public function newUniqueId(): string
    {
        return (string) Str::uuid7();
    }

    /**
     * @return Attribute<UserProviderInterface|null, never>
     */
    public function tokenable(): Attribute
    {
        return Attribute::get(
            get: function (): ?UserProviderInterface {
                if ($this->relationLoaded('tokenable')) {
                    /** @var UserProviderInterface|null $cached */
                    $cached = $this->getRelation('tokenable');

                    return $cached;
                }

                /** @var EntityManagerInterface $em */
                $em = app(abstract: EntityManagerInterface::class);

                /** @var UserProviderInterface|null $user */
                $user = $em->find(
                    className: $this->tokenable_type,
                    id: $this->tokenable_id
                );

                $this->setRelation('tokenable', $user);

                return $user;
            }
        );
    }
}
