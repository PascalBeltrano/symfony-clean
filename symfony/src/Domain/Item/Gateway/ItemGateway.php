<?php

namespace Domain\Item\Gateway;

use Domain\Item\Entity\Item;

interface ItemGateway
{
    public function create(Item $item): Item;
    public function update(Item $item): ?Item;
    public function delete(Item $item): bool;
    public function findById(int $id): ?Item;
    public function findByName(string $name): ?Item;
    public function findOtherWithSameName(int $id, string $name): ?Item;
    public function getAll(): array;
}