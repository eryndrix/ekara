<?php declare(strict_types=1);

namespace App\Shared\Application\Outcome;

/**
 * @phpstan-template TValue
 * @phpstan-template-covariant TError
 */
abstract class Result
{
    /**
     * @phpstan-param TValue|null $value
     * @phpstan-param TError|null $error
     */
    protected function __construct(
        public private(set) mixed $value = null,
        public private(set) mixed $error = null
    ) {}

    /**
     * @phpstan-template TNewValue
     * @phpstan-param TNewValue $value
     * @phpstan-return Success<TNewValue>
     */
    public static function success(mixed $value): Success
    {
        return new Success(value: $value);
    }

    /**
     * @phpstan-template TNewError
     * @phpstan-param TNewError $error
     * @phpstan-return Failure<TNewError>
     */
    public static function failure(mixed $error): Failure
    {
        return new Failure(error: $error);
    }

    /**
     * @phpstan-return bool
     */
    abstract public function isSuccess(): bool;

    /**
     * @phpstan-return bool
     */
    public function isFailure(): bool
    {
        return !$this->isSuccess();
    }

    /**
     * @phpstan-template TNewValue
     * @phpstan-param callable(TValue): TNewValue $mapper
     * @phpstan-return Result<TNewValue, TError>
     */
    public function map(callable $mapper): Result
    {
        if (!$this->isSuccess()) {
            return $this;
        }
        
        /** @phpstan-var TValue $value */
        $value = $this->value;
        return static::success(value: $mapper($value));
    }
    
    /**
     * @phpstan-template TSuperError
     * @phpstan-param callable(TError): TSuperError $mapper
     * @phpstan-return Result<TValue, TSuperError>
     */
    public function mapError(callable $mapper): Result
    {
        if ($this->isSuccess()) {
            return $this;
        }
        
        /** @phpstan-var TError $error */
        $error = $this->error;
        return static::failure(error: $mapper($error));
    }
    
    /**
     * @phpstan-template TResult
     * @phpstan-param callable(TValue): TResult $onSuccess
     * @phpstan-param callable(TError): TResult $onError
     * @phpstan-return TResult
     */
    public function match(
        callable $onSuccess, callable $onError): mixed
    {
        if ($this->isSuccess()) {
            /** @phpstan-var TValue $value */
            $value = $this->value;
            return $onSuccess($value);
        }

        /** @phpstan-var TError $error */
        $error = $this->error;
        return $onError($error);
    }
}
