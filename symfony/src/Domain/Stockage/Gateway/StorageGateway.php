<?php

namespace Domain\Stockage\Gateway;

use Domain\Stockage\Entity\Storage;

interface StorageGateway
{
    public function create(Storage $storage): Storage;
    public function findByName(string $name): ?Storage;
}