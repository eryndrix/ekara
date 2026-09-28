<?php declare(strict_types=1);

namespace App\Shared\Application\Payload;

/**
 * @phpstan-template TData of mixed
 */
final class Envelope
{
    /**
     * @phpstan-param TData $data
     * @phpstan-param array<string, mixed> $meta
     */
    public function __construct(
        public private(set) mixed $data = null,
        public private(set) array $meta = [],
    ) {}

    /**
     * @phpstan-template TNewData of mixed
     * @phpstan-param TNewData $data
     * @phpstan-return self<TNewData>
     */
    public static function with(mixed $data): self
    {
        return new self(data: $data);
    }

    /**
     * @phpstan-param array<string, mixed> $meta
     * @phpstan-return self<null>
     */
    public static function empty(array $meta = []): self
    {
        return new self(data: null, meta: $meta);
    }

    /**
     * @phpstan-param array<string, mixed> $payload
     * @phpstan-return self<TData>
     */
    public function meta(array $payload): self
    {
        return new self(
            data: $this->data,
            meta: [
                ...$this->meta,
                ...$payload
            ],
        );
    }
}
