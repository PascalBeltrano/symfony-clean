<?php

namespace Domain\Item\Response;

use Domain\Item\Entity\Item;
use Infrastructure\Symfony\Abstract\ResponseAbstract;

class CreateResponse extends ResponseAbstract
{
    public const STATUS_EXISTING        = 'EXISTING';
    public const STATUS_INVALID         = 'INVALID';
    public const STATUS_MISSING_FIELDS  = 'MISSING_FIELDS';

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

    public function isStatusExisting(): bool
    { 
        return $this->status == self::STATUS_EXISTING ? true: false;
    }

    public function isStatusInvalid(): bool
    { 
        return $this->status == self::STATUS_INVALID ? true: false;
    }
    
    public function isStatusMissingFields(): bool
    { 
        return $this->status == self::STATUS_MISSING_FIELDS ? true: false;
    }

    public function setStatusExisting(): void
    { 
        $this->setStatus(self::STATUS_EXISTING);
    }

    public function setStatusInvalid(array $fields): void
    {
        $this->setStatus(self::STATUS_INVALID);
        $this->setErrors($fields);
    }

    public function setStatusMissingFields(array $fields): void
    {
        $this->setStatus(self::STATUS_MISSING_FIELDS);
        $this->setErrors($fields);
    }
    
    public function setStatusSuccess(): void
    {
        $this->setStatus(self::STATUS_SUCCESS);
    }
}