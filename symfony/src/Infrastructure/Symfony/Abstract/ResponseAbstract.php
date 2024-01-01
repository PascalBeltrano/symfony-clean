<?php

namespace Infrastructure\Symfony\Abstract;

abstract class ResponseAbstract
{
    public const STATUS_DEFAULT = 'DEFAULT';
    public const STATUS_SUCCESS = 'SUCCESS';

    protected string $status = self::STATUS_DEFAULT;
    protected ?array $errors = null;

    final public function getStatus(): string
    {
        return $this->status;
    }

    final protected function setStatus(string $status): void
    {
        $this->status = $status;
    }

    final public function getErrors(): ?array
    {
        return $this->errors;
    }

    final protected function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    final public function isStatusSuccess(): bool
    { 
        return $this->status == self::STATUS_SUCCESS ? true: false;
    }

    abstract public function setStatusSuccess(): void;
}