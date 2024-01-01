<?php

namespace Domain\Item\Response;

use Domain\Item\Entity\Item;
use Infrastructure\Symfony\Abstract\ResponseAbstract;

class GetByIdResponse extends ResponseAbstract
{
    public const STATUS_NO_RESULT   = 'NO_RESULT';

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
    
    public function isStatusNoResult(): bool
    { 
        return $this->status == self::STATUS_NO_RESULT ? true: false;
    }
    
    public function setStatusNoResult(): void
    {
        $this->setStatus(self::STATUS_NO_RESULT);
    }

    public function setStatusSuccess(): void
    {
        $this->setStatus(self::STATUS_SUCCESS);
    }
}