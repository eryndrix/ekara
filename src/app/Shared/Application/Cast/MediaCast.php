<?php declare(strict_types=1);

namespace App\Shared\Application\Cast;

use WendellAdriel\ValidatedDTO\Casting\Castable;
use Illuminate\Http\UploadedFile;

/**
 * @phpstan-template TProperty of string
 * @phpstan-template TValue
 */
final class MediaCast implements Castable
{
    /**
     * @phpstan-param TProperty $property
     * @phpstan-param TValue $value
     * 
     * @phpstan-return UploadedFile|null
     */
    public function cast(
        string $property, mixed $value): ?UploadedFile
    {
        if ($value instanceof UploadedFile) {
            return $value;
        }

        return null;
    }
}
