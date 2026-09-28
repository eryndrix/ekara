<?php declare(strict_types=1);

namespace App\Shared\Domain\Value\Slug;

/**
 * @phpstan-extends UniqueSlug<PermissionSlug>
 */
final class PermissionSlug extends UniqueSlug
{
    /**
     * @phpstan-param string $slug
     */
	public function __construct(string $slug)
	{
	    if (strlen(string: $slug) > 50
	    	|| strlen(string: $slug) < 3
	    ) {
	        throw new \DomainException(
	        	message: 'Permission slug 3-50 chars.'
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
