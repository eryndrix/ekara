<?php declare(strict_types=1);

namespace App\Shared\Domain\Value\Slug;

use Doctrine\ORM\Mapping as ORM;
use App\Shared\Domain\Primitive;
use Illuminate\Support\Str;

/**
 * @template-covariant TSlug of UniqueSlug
 * @phpstan-extends Primitive<string>
 * @phpstan-consistent-constructor
 */
#[ORM\MappedSuperclass]
abstract class UniqueSlug extends Primitive
{
    /**
     * @phpstan-var string
     */
    private string $slug {
        set (string $value) => $this->slug = $value
            |> trim(...)
            |> (fn (string $slug): string => mb_strtolower(
                    string: $slug,
                    encoding: 'UTF-8'
                )
            );
    }

    /**
     * @phpstan-param string $slug
     */
    protected function __construct(string $slug)
    {
        if ($slug === '') {
            throw new \DomainException(
                message: 'Slug cannot be empty.'
            );
        }
        
        $this->slug = $slug;
    }

    /**
     * @internal
     * 
     * @phpstan-param string $slug
     * @phpstan-return static<TSlug>
     */
    abstract protected static function make(string $slug): static;

    /**
     * @phpstan-param string $value
     * @phpstan-return static<TSlug>
     */
    public static function of(string $value): static
    {
        return static::make(slug: $value);
    }

    /**
     * @phpstan-param string $title
     * @phpstan-return static<TSlug>
     */
    public static function generate(string $title): static
    {
        $slug = Str::slug(title: $title);
        return static::make(slug: $slug);
    }

    /**
     * @phpstan-return string
     */
    public function value(): string
    {
        return $this->slug;
    }

    /**
     * @phpstan-return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
