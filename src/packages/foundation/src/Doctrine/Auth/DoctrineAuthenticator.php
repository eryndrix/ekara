<?php declare(strict_types=1);

namespace Foundation\Doctrine\Auth;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Foundation\Auth\UserProviderInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Support\Arrayable;

class DoctrineAuthenticator implements AuthenticatorInterface
{
    /**
     * @var HasherContract
     */
    protected HasherContract $hasher;

    /**
     * @var class-string<UserProviderInterface>
     */
    protected string $model;

    /**
     * @var (\Closure(QueryBuilder):mixed)|null
     */
    protected ?\Closure $queryCallback = null;

    /**
     * @param HasherContract $hasher
     * @param class-string<UserProviderInterface> $model
     */
    public function __construct(HasherContract $hasher, string $model)
    {
        $this->model = $model;
        $this->hasher = $hasher;
    }

    /**
     * @param mixed $identifier
     * @return Authenticatable|null
     */
    public function retrieveById($identifier): ?Authenticatable
    {
        $idName = $this->model::PRIMARY_KEY;

        $result = $this->newModelQuery()
            ->andWhere(sprintf('u.%s = :id', $idName))
            ->setParameter(key: 'id', value: $identifier)
            ->getQuery()
            ->getOneOrNullResult();

        return $result instanceof Authenticatable ? $result : null;
    }

    /**
     * @param mixed $identifier
     * @param string $token
     *
     * @return Authenticatable|null
     */
    public function retrieveByToken(
        $identifier, #[\SensitiveParameter] $token): ?Authenticatable
    {
        $user = $this->retrieveById(identifier: $identifier);

        if (!$user instanceof UserProviderInterface) {
            return null;
        }

        if (!$user->isRememberTokenValid(token: (string) $token)) {
            return null;
        }

        return $user;
    }

    /**
     * @param Authenticatable $user
     * @param string $token
     *
     * @return void
     */
    public function updateRememberToken(
        Authenticatable $user, #[\SensitiveParameter] $token): void
    {
        if (!$user instanceof UserProviderInterface) {
            return;
        }

        $user->setRememberToken(value: $token);

        $this->entityManager()->persist(object: $user);
        $this->entityManager()->flush();
    }

    /**
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function retrieveByCredentials(
        #[\SensitiveParameter] array $credentials): ?Authenticatable
    {
        $credentials = array_filter(
            array: $credentials,
            callback: static fn (string $key): bool => !str_contains(
                haystack: $key,
                needle: 'password'
            ),
            mode: ARRAY_FILTER_USE_KEY
        );

        if (empty($credentials)) {
            return null;
        }

        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if (!preg_match(
                pattern: '/^[a-zA-Z_][a-zA-Z0-9_]*$/',
                subject: (string) $key
            )) {
                throw new \InvalidArgumentException(
                    message: sprintf(
                        'Invalid credential field: %s',
                        $key
                    )
                );
            }

            if ($value instanceof Arrayable) {
                $value = $value->toArray();
            }

            if (is_array(value: $value)) {
                $query->andWhere(
                    sprintf('u.%s IN (:%s)', $key, $key)
                )->setParameter(
                    key: $key,
                    value: $value
                );
            } elseif ($value instanceof \Closure) {
                $value($query);
            } else {
                $query->andWhere(
                    sprintf('u.%s = :%s', $key, $key)
                )->setParameter(
                    key: $key,
                    value: $value
                );
            }
        }

        $result = $query->getQuery()->getOneOrNullResult();

        return $result instanceof Authenticatable ? $result : null;
    }

    /**
     * @param Authenticatable $user
     * @param array $credentials
     *
     * @return bool
     */
    public function validateCredentials(
        Authenticatable $user,
        #[\SensitiveParameter] array $credentials): bool
    {
        if (!$user instanceof UserProviderInterface) {
            return false;
        }

        if (is_null(value: $plain = $credentials['password'] ?? null)) {
            return false;
        }

        $hashed = $user->getAuthPassword();

        if ($hashed === '') {
            return false;
        }

        return $this->hasher->check(
            value: $plain,
            hashedValue: $hashed
        );
    }

    /**
     * @param Authenticatable $user
     * @param array $credentials
     * @param bool $force
     *
     * @return void
     */
    public function rehashPasswordIfRequired(
        Authenticatable $user,
        #[\SensitiveParameter] array $credentials,
        bool $force = false): void
    {
        if (!$user instanceof UserProviderInterface) {
            return;
        }

        if (!$this->hasher->needsRehash(
            $user->getAuthPassword()
        ) && !$force) {
            return;
        }

        if (!isset($credentials['password'])) {
            return;
        }

        $user->setAuthPassword(
            password: $this->hasher->make(
                value: $credentials['password']
            )
        );

        $this->entityManager()->persist(object: $user);
        $this->entityManager()->flush();
    }

    /**
     * @return QueryBuilder
     */
    protected function newModelQuery(): QueryBuilder
    {
        $query = $this->entityManager()
            ->getRepository(className: $this->model)
            ->createQueryBuilder('u');

        if ($this->queryCallback !== null) {
            with(value: $query, callback: $this->queryCallback);
        }

        return $query;
    }

    /**
     * @return HasherContract
     */
    public function getHasher(): HasherContract
    {
        return $this->hasher;
    }

    /**
     * @param HasherContract $hasher
     * @return $this
     */
    public function setHasher(HasherContract $hasher): static
    {
        $this->hasher = $hasher;

        return $this;
    }

    /**
     * @return class-string<UserProviderInterface>
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param class-string<UserProviderInterface> $model
     * @return $this
     */
    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return (\Closure(QueryBuilder):mixed)|null
     */
    public function getQueryCallback(): ?\Closure
    {
        return $this->queryCallback;
    }

    /**
     * @param (\Closure(QueryBuilder):mixed)|null $queryCallback
     * @return $this
     */
    public function withQuery(?\Closure $queryCallback = null): static
    {
        $this->queryCallback = $queryCallback;

        return $this;
    }

    /**
     * @return EntityManagerInterface
     */
    protected function entityManager(): EntityManagerInterface
    {
        return app(abstract: EntityManagerInterface::class);
    }
}
