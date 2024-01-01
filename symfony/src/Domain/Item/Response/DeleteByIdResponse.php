<?php

namespace Domain\Item\Response;

use Infrastructure\Symfony\Abstract\ResponseAbstract;

class DeleteByIdResponse extends ResponseAbstract
{
    public const STATUS_NO_FOUND    = "NO_FOUND";
    public const STATUS_NO_DELETED  = "NO_DELETED";

    public function __construct(
    )
    {
    }

    public function setStatusSuccess(): void
    {
        $this->setStatus(self::STATUS_SUCCESS);
    }

    public function isStatusNoResult(): bool
    { 
        return $this->status == self::STATUS_NO_FOUND ? true: false;
    }
    
    public function setStatusNoResult(): void
    {
        $this->setStatus(self::STATUS_NO_FOUND);
    }

    public function isStatusNoDeleted(): bool
    {
        return $this->status == self::STATUS_NO_DELETED ? true: false;
    }

    public function setStatusNoDeleted(): void
    {
        $this->setStatus(self::STATUS_NO_DELETED);
    }
}