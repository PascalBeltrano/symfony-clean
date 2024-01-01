<?php

namespace Infrastructure\Tests\Repository;

use Domain\Item\Entity\Item;
use Domain\Item\Gateway\ItemGateway;

class ItemRepository implements ItemGateway
{
    public function create(Item $item): Item { 
        return $item;
    }
    public function update(Item $item): Item {
        return $item;
    }
    public function delete(Item $item): bool {
        return true;
    }
    public function findById(int $id): ?Item
    {
        if($id == 1) return new Item('Livre', '10.15', 1);
        return null;
    }
    public function findByName(string $name): ?Item
    {
        if($name == 'Livre') return new Item('Livre', '10.15', 1);
        return null;
    }
    public function findOtherWithSameName(int $id, string $name): ?Item
    {
        if($name == 'Radio' & $id != '1') return new Item('Livre', '10.15', 1);
        return null;
    }
    public function getAll(): array
    {
        $items = array();
        array_push($items, new Item('Livre', '10.15', 1));
        array_push($items, new Item('Bois', '2.00', 2));
        array_push($items, new Item('Charbon', '0.15', 3));
        array_push($items, new Item('Bière', '12.99', 4));
        array_push($items, new Item('Bouteille', '2.08', 5));
        array_push($items, new Item('Pomme', '1.00', 6));
        return $items;
    }
}