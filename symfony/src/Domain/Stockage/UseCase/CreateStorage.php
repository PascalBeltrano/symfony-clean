<?php

namespace Domain\Stockage\UseCase;

use Domain\Stockage\Entity\Storage;
use Domain\Stockage\Gateway\StorageGateway;
use Domain\Stockage\Request\CreateStorageRequest;
use Domain\Stockage\Response\CreateStorageResponse;
use Domain\Stockage\Validator\CreateStorageRequestValidator;

class CreateStorage
{
    public function __construct(
        private StorageGateway $storageGateway,
        private CreateStorageRequestValidator $requestValidator
    )
    {
    }

    public function execute(CreateStorageRequest $request): CreateStorageResponse
    {
        $response = new CreateStorageResponse();

        if($this->requestValidator->ifMissingFields($request))
        {
            $response->setStatusMissingFields($this->requestValidator->getMissingFields($request));
            return $response;
        }

        if(!$this->requestValidator->isValid($request))
        {
            $response->setStatusInvalid($this->requestValidator->getErrors($request));
            return $response;
        }

        if($this->storageGateway->findByName($request->getName()))
        {
            $response->setStatusExisting();
            return $response;
        }

        $storage = Storage::new($request);
        $this->storageGateway->create($storage);

        $response->setStorage($storage);
        $response->setStatusSuccess();

        return $response;
    }
}