<?php

namespace Domain\Stockage\Request;

class CreateStorageRequest
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

    public function getCity(): ?string
    {
        return $this->content->city ?? null;
    }

}