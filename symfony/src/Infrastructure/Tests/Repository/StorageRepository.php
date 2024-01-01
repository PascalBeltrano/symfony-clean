<?php

namespace Infrastructure\Tests\Repository;

use Domain\Stockage\Entity\Storage;
use Domain\Stockage\Gateway\StorageGateway;

class StorageRepository implements StorageGateway
{
    public function create(Storage $storage): Storage { 
        return $storage;
    }
    public function findByName(string $name): ?Storage
    {
        if($name == 'Stock Alimentaire - Istres') return new Storage('Stock Alimentaire - Istres', 'Istres', 1);
        return null;
    }
}