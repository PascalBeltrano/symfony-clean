<?php

namespace Domain\Item\UseCase;

use Domain\Item\Entity\Item;
use Domain\Item\Gateway\ItemGateway;
use Domain\Item\Request\CreateRequest;
use Domain\Item\Response\CreateResponse;
use Domain\Item\Validator\CreateRequestValidator;

class Create
{
    public function __construct(
        private ItemGateway $itemGateway,
        private CreateRequestValidator $requestValidator
    )
    {
    }

    public function execute(CreateRequest $request): CreateResponse
    {
        $response = new CreateResponse();

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

        if($this->itemGateway->findByName($request->getName()))
        {
            $response->setStatusExisting();
            return $response;
        }
        
        $item = Item::new($request);
        $this->itemGateway->create($item);

        $response->setItem($item);
        $response->setStatusSuccess();
        
        return $response;
    }
}