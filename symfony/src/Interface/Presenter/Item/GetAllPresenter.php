<?php

namespace Interface\Presenter\Item;

use Domain\Item\Presenter\GetAllPresenterInterface;
use Domain\Item\Response\GetAllResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class GetAllPresenter implements GetAllPresenterInterface
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {
    }

    public function present(
        GetAllResponse $response
    ): JsonResponse
    {
        $statusCode=500;
        $content=(object)[];
        $content->message = "Erreur inconnue";

        $items = $response->getItems();
        $nbItems = count($items);

        if($response->isStatusSuccess() && $nbItems > 0)
        {
            $serializedItems = [];
            foreach ($items as $item) {
                $serializedItems[] = json_decode($this->serializer->serialize($item, 'json'));
            }

            $statusCode = 200;
            $content->message = "$nbItems Item(s) retourné(s)";
            $content->items = $serializedItems;
        }
        elseif($response->isStatusSuccess())
        {
            $statusCode = 200;
            $content->message = "Aucun Item en base de données";
        }

        $jsonResponse=new JsonResponse();
        $jsonResponse->setStatusCode($statusCode);
        $jsonResponse->setData($content);

        return $jsonResponse;
    }
}