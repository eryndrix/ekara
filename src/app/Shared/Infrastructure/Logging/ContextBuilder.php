<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Logging;

final class ContextBuilder
{
    /**
     * @phpstan-param array<string, bool> $config
     */
    public function __construct(
        private readonly array $config
    ) {}

    /**
     * @phpstan-param \Throwable $exception
     * @phpstan-return array<string, mixed>
     */
    public function build(\Throwable $exception): array
    {
        $context = [];

        if ($this->config['exception'] ?? false) {
            $context['exception'] = $exception::class;
        }

        if ($this->config['code'] ?? false) {
            $context['code'] = (int) $exception->getCode();
        }

        if ($this->config['file'] ?? false) {
            $context['file'] = $exception->getFile();
        }

        if ($this->config['line'] ?? false) {
            $context['line'] = $exception->getLine();
        }

        if ($this->config['trace'] ?? false) {
            $context['trace'] = $exception->getTraceAsString();
        }

        return $context;
    }

    /**
     * @phpstan-param string $level
     * @phpstan-param \Throwable $exception
     * 
     * @phpstan-return array<string, mixed>
     */
    public static function fromConfig(
        string $level, \Throwable $exception): array
    {
        /** @phpstan-var array<string, bool> $config */
        $config = config(
            key: "exception-logger.context.{$level}",
            default: [
                'exception' => true,
                'code' => false,
                'file' => false,
                'line' => false,
                'trace' => false
            ]
        );

        $builder = new self(config: $config);
        return $builder->build(exception: $exception);
    }
}
