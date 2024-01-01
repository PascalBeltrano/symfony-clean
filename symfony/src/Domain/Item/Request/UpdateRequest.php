<?php

namespace Domain\Item\Request;

class UpdateRequest
{
    public static function create(int $id, object $content): self
    {
        return new self($id, $content);
    }

    public function __construct(
        private int $id,
        private object $content
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->content->name ?? null;
    }

    public function getPrice(): ?float
    {
        return $this->content->price ?? null;
    }
}