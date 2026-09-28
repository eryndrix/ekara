<?php declare(strict_types=1);

namespace App\Shared\Application\Payload;

use WendellAdriel\ValidatedDTO\Concerns\EmptyCasts;
use WendellAdriel\ValidatedDTO\SimpleDTO;

abstract class Command extends SimpleDTO
{
    /**
     * Empty casts support.
     */
    use EmptyCasts;

    /**
     * @phpstan-return array<string, mixed>
     */
    protected function rules(): array
    {
        return [];
    }

    /**
     * @phpstan-return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [];
    }

    /**
     * @phpstan-return array<string, mixed>
     */
    protected function casts(): array
    {
        return [];
    }
}
