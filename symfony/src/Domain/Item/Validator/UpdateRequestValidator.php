<?php

namespace Domain\Item\Validator;

use Domain\Item\Gateway\ItemGateway;
use Domain\Item\Request\UpdateRequest;
use Infrastructure\Tools\Validator;

class UpdateRequestValidator
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

    public function isValid(UpdateRequest $request): bool
    {
        $name = $request->getName();
        $price = $request->getPrice();

        if($name !== null) {
            $this->validator->fieldLenghtGreaterThan('name', $request->getName(), 3);
            $this->validator->fieldLenghtLessThan('name', $request->getName(), 100);
        }
        if($price !== null) {
            $this->validator->fieldGreaterThan('price',$request->getPrice(), 0);
        }

        return $this->validator->isValid();
    }
}