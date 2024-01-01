<?php

namespace Domain\Item\UseCase;

use Domain\Item\Gateway\ItemGateway;
use Domain\Item\Request\GetByIdRequest;
use Domain\Item\Response\GetByIdResponse;

class GetById
{
    public function __construct(
        private ItemGateway $itemGateway
    )
    {
    }

    public function execute(GetByIdRequest $request): GetByIdResponse
    {
        $response = new GetByIdResponse();

        $idItem = $request->getId();
        $item = $this->itemGateway->findById($idItem);

        if($item === NULL)
        {
            $response->setStatusNoResult();
            
            return $response;
        }

        $response->setItem($item);
        $response->setStatusSuccess();
        
        return $response;
    }
}