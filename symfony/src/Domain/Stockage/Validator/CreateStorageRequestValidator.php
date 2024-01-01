<?php

namespace Domain\Stockage\Validator;

use Domain\Stockage\Request\CreateStorageRequest;
use Infrastructure\Tools\Assertion;
use Infrastructure\Tools\Validator;

class CreateStorageRequestValidator
{
    private Validator $validator;
    
    public function __construct(
    )
    {
        $this->validator = new Validator();
    }

    public function getErrors(): array
    {
        return $this->validator->getErrors();
    }

    public function getMissingFields(CreateStorageRequest $request): array
    {
        $fields = array();

        if(!Assertion::notNull($request->getName())) array_push($fields, 'name');
        if(!Assertion::notNull($request->getCity())) array_push($fields, 'city');

        return $fields;
    }

    public function isValid(CreateStorageRequest $request): bool
    {
        $this->validator->fieldLenghtGreaterThan('name', $request->getName(), 3);
        $this->validator->fieldLenghtLessThan('name', $request->getName(), 200);
        $this->validator->fieldLenghtGreaterThan('city', $request->getCity(), 3);
        $this->validator->fieldLenghtLessThan('city', $request->getCity(), 200);
        return $this->validator->isValid();
    }

    public function ifMissingFields(CreateStorageRequest $request): bool
    {
        $this->validator->fieldNotNull('name', $request->getName());
        $this->validator->fieldNotNull('city', $request->getCity());
        return $this->validator->isValid()? false: true;
    }
}