<?php

namespace Domain\Item\Response;

use Domain\Item\Entity\Item;
use Infrastructure\Symfony\Abstract\ResponseAbstract;

class UpdateResponse extends ResponseAbstract
{
    public const STATUS_INVALID         = 'INVALID';
    public const STATUS_NO_FOUND        = 'NO_FOUND';
    public const STATUS_NO_UNIQUE_NAME  = 'NO_UNIQUE_NAME';

    public function __construct(
        private ?Item $item = null
    )
    {   
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(Item $item): void
    {
        $this->item = $item;
    }

    public function setStatusSuccess(): void
    {
        $this->setStatus(self::STATUS_SUCCESS);
    }

    public function setStatusNoFound(): void
    {
        $this->setStatus(self::STATUS_NO_FOUND);
    }

    public function ifStatusNoFound(): bool
    {
        return $this->status == self::STATUS_NO_FOUND ? true: false;
    }

    public function setStatusInvalid(array $errors): void
    {
        $this->setStatus(self::STATUS_INVALID);
        $this->setErrors($errors);
    }

    public function ifStatusInvalid(): bool
    {
        return $this->status == self::STATUS_INVALID ? true: false;
    }

    public function setStatusNoUniqueName(): void
    {
        $this->setStatus(self::STATUS_NO_UNIQUE_NAME);
    }

    public function ifStatusNoUniqueName(): bool
    {
        return $this->status == self::STATUS_NO_UNIQUE_NAME ? true: false;
    }
}