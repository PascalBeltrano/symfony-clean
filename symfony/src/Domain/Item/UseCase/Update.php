<?php

namespace Domain\Item\UseCase;

use Domain\Item\Gateway\ItemGateway;
use Domain\Item\Request\UpdateRequest;
use Domain\Item\Response\UpdateResponse;
use Domain\Item\Validator\UpdateRequestValidator;

class Update
{
    public function __construct(
        private ItemGateway $itemGateway,
        private UpdateRequestValidator $requestValidator
    )
    {
    }

    public function execute(UpdateRequest $request): UpdateResponse
    {
        $response = new UpdateResponse();

        $idItem = $request->getId();
        $item = $this->itemGateway->findById($idItem);
        if($item == null)
        {
            $response->setStatusNoFound();
            return $response;
        }

        if($request->getName()) {
            $otherItem = $this->itemGateway->findOtherWithSameName($idItem, $request->getName());
            if($otherItem != null) {
                $response->setStatusNoUniqueName();
                $response->setItem($otherItem);
                return $response;
            }
        }
        
        if(!$this->requestValidator->isValid($request, $this->itemGateway))
        {
            $response->setStatusInvalid($this->requestValidator->getErrors($request));
            return $response;
        }

        if($request->getName()) $item->setName($request->getName());
        if($request->getPrice()) $item->setPrice($request->getPrice());
        
        $item = $this->itemGateway->update($item);

        $response->setItem($item);
        $response->setStatusSuccess();

        return $response;
    }
}