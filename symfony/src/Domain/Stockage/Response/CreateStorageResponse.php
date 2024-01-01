<?php

namespace Domain\Stockage\Response;

use Domain\Stockage\Entity\Storage;
use Infrastructure\Symfony\Abstract\ResponseAbstract;

class CreateStorageResponse extends ResponseAbstract
{
    public const STATUS_EXISTING        = 'EXISTING';
    public const STATUS_INVALID         = 'INVALID';
    public const STATUS_MISSING_FIELDS  = 'MISSING_FIELDS';

    public function __construct(
        private ?Storage $storage = null
    )
    {
    }

    public function getStorage(): ?Storage
    {
        return $this->storage;
    }

    public function setStorage(Storage $storage): void
    {
        $this->storage = $storage;
    }

    public function setStatusSuccess(): void
    {
        $this->setStatus(self::STATUS_SUCCESS);
    }

    public function isStatusExisting(): bool
    { 
        return $this->status == self::STATUS_EXISTING ? true: false;
    }

    public function setStatusExisting(): void
    { 
        $this->setStatus(self::STATUS_EXISTING);
    }

    public function isStatusInvalid(): bool
    { 
        return $this->status == self::STATUS_INVALID ? true: false;
    }

    public function setStatusInvalid(array $fields): void
    {
        $this->setStatus(self::STATUS_INVALID);
        $this->setErrors($fields);
    }

    public function isStatusMissingFields(): bool
    { 
        return $this->status == self::STATUS_MISSING_FIELDS ? true: false;
    }

    public function setStatusMissingFields(array $fields): void
    {
        $this->setStatus(self::STATUS_MISSING_FIELDS);
        $this->setErrors($fields);
    }
}