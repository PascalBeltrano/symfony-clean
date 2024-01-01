<?php

namespace Domain\Item\Request;

class GetByIdRequest
{
    public static function create(int $id): self
    {
        return new self($id);
    }

    public function __construct(
        private int $id
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}