<?php

namespace Domain\Item\UseCase;

use Domain\Item\Gateway\ItemGateway;
use Domain\Item\Response\GetAllResponse;
use Exception;

class GetAll
{
    public function __construct(
        private ItemGateway $itemGateway
    )
    {
    }

    public function execute(): GetAllResponse
    {
        $response = new GetAllResponse();
        
        try
        {
            $items = $this->itemGateway->getAll();
            $response->setItems($items);
            $response->setStatusSuccess();
        }
        catch(Exception $e)
        {
            return $response;
        }

        return $response;
    }
}