<?php

namespace Domain\Item\Response;

use Infrastructure\Symfony\Abstract\ResponseAbstract;

class GetAllResponse extends ResponseAbstract
{
    public function __construct(
        private ?array $items = null
    )
    {
    }

    public function getItems(): ?array
    {
        return $this->items;
    }

    public function setItems(?array $items): void
    {
        $this->items = $items;
    }

    public function setStatusSuccess(): void
    {
        $this->setStatus(self::STATUS_SUCCESS);
    }
}