<?php

namespace Domain\Item\UseCase;

use Domain\Item\Gateway\ItemGateway;
use Domain\Item\Request\DeleteByIdRequest;
use Domain\Item\Response\DeleteByIdResponse;

class DeleteById
{
    public function __construct(
        private ItemGateway $itemGateway
    )
    {
    }

    public function execute(DeleteByIdRequest $request): DeleteByIdResponse
    {
        $response = new DeleteByIdResponse;

        $idItem = $request->getId();
        $item = $this->itemGateway->findById($idItem);

        if($item === NULL)
        {
            $response->setStatusNoResult();
            
            return $response;
        }

        if(!$this->itemGateway->delete($item)) {
            $response->setStatusNoDeleted();

            return $response;
        }

        $response->setStatusSuccess();

        return $response;
    }
}