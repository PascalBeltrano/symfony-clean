<?php

namespace Domain\Item\Request;

class CreateRequest
{
    public static function create(object $content): self
    {
        return new self($content);
    }

    public function __construct(
        private object $content
    )
    {
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