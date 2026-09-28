<?php declare(strict_types=1);

namespace App\Shared\Domain\Value\Slug;

/**
 * @phpstan-extends UniqueSlug<RoleSlug>
 */
final class RoleSlug extends UniqueSlug
{
    /**
     * @phpstan-param string $slug
     */
	public function __construct(string $slug)
	{
	    if (strlen(string: $slug) > 20
	    	|| strlen(string: $slug) < 3
	    ) {
	        throw new \DomainException(
	        	message: 'Role slug 3-20 chars.'
	        );
	    }
	    
	    parent::__construct(slug: $slug);
	}

	/**
     * @phpstan-param string $slug
     * @phpstan-return self
     */
    protected static function make(string $slug): self
    {
        return new self(slug: $slug);
    }
}
