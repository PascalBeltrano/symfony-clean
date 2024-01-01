<?php
 
namespace Domain\Item\Entity;

use Domain\Item\Request\CreateRequest;

class Item {
    public static function new(
        CreateRequest $request
    ): self
    {
        return new self(
            $request->getName(),
            $request->getPrice()
        );
    }

    public function __construct(
        private string $name,
        private float $price,
        private int $id = 0
    )
    {
        
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

}