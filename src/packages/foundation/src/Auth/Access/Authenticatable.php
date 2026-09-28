<?php declare(strict_types=1);

namespace Foundation\Auth\Access;

trait Authenticatable
{
    /**
     * @return string
     */
    public function getKeyName(): string
    {
        return static::PRIMARY_KEY;
    }

    /**
     * @return mixed
     */
    public function getKey(): mixed
    {
        return $this->{static::PRIMARY_KEY};
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName(): string
    {
        return $this->getKeyName();
    }

    /**
     * @return string
     */
    public function getAuthIdentifier(): string
    {
        return (string) $this->getKey();
    }

    /**
     * @return string
     */
    public function getAuthIdentifierForBroadcasting(): string
    {
        return $this->getAuthIdentifier();
    }

    /**
     * @return string
     */
    public function getAuthPasswordName(): string
    {
        return static::AUTH_PASSWORD_NAME;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setAuthPassword(string $password): void
    {
        $current = $this->{static::AUTH_PASSWORD_NAME};

        if (is_object(value: $current)) {
            $this->{static::AUTH_PASSWORD_NAME} = new ($current::class)($password);

            return;
        }

        $this->{static::AUTH_PASSWORD_NAME} = $password;
    }

    /**
     * @return string
     */
    public function getAuthPassword(): string
    {
        return (string) $this->{static::AUTH_PASSWORD_NAME};
    }

    /**
     * @return string|null
     */
    public function getRememberToken(): ?string
    {
        if (static::REMEMBER_TOKEN_NAME === '') {
            return null;
        }

        $value = $this->{static::REMEMBER_TOKEN_NAME} ?? null;
        return $value !== null ? (string) $value : null;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setRememberToken($value): void
    {
        if (static::REMEMBER_TOKEN_NAME === '') {
            return;
        }

        $this->{static::REMEMBER_TOKEN_NAME} = $value;
    }

    /**
     * @return string
     */
    public function getRememberTokenName(): string
    {
        return static::REMEMBER_TOKEN_NAME;
    }

    /**
     * @return void
     */
    public function generateRememberToken(): void
    {
        $this->{static::REMEMBER_TOKEN_NAME} = bin2hex(
            string: random_bytes(length: 32)
        );
    }

    /**
     * @return void
     */
    public function invalidateRememberToken(): void
    {
        $this->{static::REMEMBER_TOKEN_NAME} = null;
    }

    /**
     * @return bool
     */
    public function hasRememberToken(): bool
    {
        return $this->{static::REMEMBER_TOKEN_NAME} !== null;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isRememberTokenValid(string $token): bool
    {
        if ($this->{static::REMEMBER_TOKEN_NAME} === null) {
            return false;
        }

        return hash_equals(
            known_string: $this->{static::REMEMBER_TOKEN_NAME},
            user_string: $token
        );
    }
}
