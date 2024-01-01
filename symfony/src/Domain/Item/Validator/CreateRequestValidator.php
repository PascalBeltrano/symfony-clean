<?php

namespace Domain\Item\Validator;

use Domain\Item\Request\CreateRequest;
use Infrastructure\Tools\Assertion;
use Infrastructure\Tools\Validator;

class CreateRequestValidator
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

    public function getMissingFields(CreateRequest $request): array
    {
        $fields = array();

        if(!Assertion::notNull($request->getName())) array_push($fields, 'name');
        if(!Assertion::notNull($request->getPrice())) array_push($fields, 'price');

        return $fields;
    }

    public function isValid(CreateRequest $request): bool
    {
        $this->validator->fieldLenghtGreaterThan('name', $request->getName(), 3);
        $this->validator->fieldLenghtLessThan('name', $request->getName(), 100);
        $this->validator->fieldGreaterThan('price',$request->getPrice(), 0);
        return $this->validator->isValid();
    }

    public function ifMissingFields(CreateRequest $request): bool
    {
        $this->validator->fieldNotNull('name', $request->getName());
        $this->validator->fieldNotNull('price', $request->getPrice());
        return $this->validator->isValid()? false: true;
    }
}