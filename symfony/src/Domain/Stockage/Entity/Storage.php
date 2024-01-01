<?php

namespace Domain\Stockage\Entity;

use Domain\Stockage\Request\CreateStorageRequest;

class Storage {
    public static function new(
        CreateStorageRequest $request,
    ): self
    {
        return new self(
            $request->getName(),
            $request->getCity()
            
        );
    }

    public function __construct(
        private string $name,
        private string $city,
        private int $id= 0
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

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }
}