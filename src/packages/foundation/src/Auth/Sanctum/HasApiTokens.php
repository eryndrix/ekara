<?php declare(strict_types=1);

namespace Foundation\Auth\Sanctum;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Laravel\Sanctum\Contracts\HasAbilities;
use Laravel\Sanctum\NewAccessToken;

trait HasApiTokens
{
    /**
     * @var HasAbilities|null
     */
    protected ?HasAbilities $accessToken = null;

    /**
     * @return Builder<Token>
     */
    public function tokens(): Builder
    {
        return Token::query()
            ->where(
                column: 'tokenable_type',
                operator: '=',
                value: static::class
            )
            ->where(
                column: 'tokenable_id',
                operator: '=',
                value: $this->getAuthIdentifier()
            );
    }

    /**
     * @param string $ability
     * @return bool
     */
    public function tokenCan(string $ability): bool
    {
        return $this->accessToken !== null
            && $this->accessToken->can(ability: $ability);
    }

    /**
     * @param string $ability
     * @return bool
     */
    public function tokenCant(string $ability): bool
    {
        return !$this->tokenCan(ability: $ability);
    }

    /**
     * @param string $name
     * @param array<int, string> $abilities
     * @param \DateTimeInterface|null $expiresAt
     *
     * @return NewAccessToken
     */
    public function createToken(
        string $name,
        array $abilities = ['*'],
        ?\DateTimeInterface $expiresAt = null): NewAccessToken
    {
        $plainTextToken = $this->generateTokenString();

        /** @var Token $token */
        $token = Token::query()->forceCreate([
            'name' => $name,
            'token' => hash(
                algo: 'sha256',
                data: $plainTextToken
            ),
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
            'tokenable_id' => $this->getAuthIdentifier(),
            'tokenable_type' => static::class,
        ]);

        return new NewAccessToken(
            accessToken: $token,
            plainTextToken: $token->getKey() . '|' . $plainTextToken
        );
    }

    /**
     * @return HasAbilities|null
     */
    public function currentAccessToken(): ?HasAbilities
    {
        return $this->accessToken;
    }

    /**
     * @param HasAbilities $accessToken
     * @return static
     */
    public function withAccessToken($accessToken): static
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return string
     */
    protected function generateTokenString(): string
    {
        /** @var string $prefix */
        $prefix = config(
            key: 'sanctum.token_prefix',
            default: ''
        );

        $tokenEntropy = Str::random(length: 40);

        return sprintf(
            '%s%s%s',
            $prefix,
            $tokenEntropy,
            hash(
                algo: 'crc32b',
                data: $tokenEntropy
            )
        );
    }
}
