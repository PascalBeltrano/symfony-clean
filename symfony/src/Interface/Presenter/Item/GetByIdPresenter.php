<?php

namespace Interface\Presenter\Item;

use Domain\Item\Presenter\GetByIdPresenterInterface;
use Domain\Item\Response\GetByIdResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class GetByIdPresenter implements GetByIdPresenterInterface
{
    public function __construct(
        private SerializerInterface $serializer
    )
    { 
    }

    public function present(GetByIdResponse $response): JsonResponse
    {
        $statusCode=500;
        $content=(object)[];
        $content->message = "Erreur inconnue";

        if($response->isStatusSuccess())
        {
            $serializedItem = json_decode($this->serializer->serialize($response->getItem(), 'json'));

            $statusCode = 200;
            $content->message = "Item récupéré";
            $content->item = $serializedItem;
        }
        elseif($response->isStatusNoResult())
        {
            $statusCode = 200;
            $content->message = "L'ID n'est lié à aucun Item";
        }

        $jsonResponse=new JsonResponse();
        $jsonResponse->setStatusCode($statusCode);
        $jsonResponse->setData($content);

        return $jsonResponse;
    }
}