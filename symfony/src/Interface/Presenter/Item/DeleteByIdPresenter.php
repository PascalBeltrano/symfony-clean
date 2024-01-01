<?php

namespace Interface\Presenter\Item;

use Domain\Item\Presenter\DeleteByIdPresenterInterface;
use Domain\Item\Response\DeleteByIdResponse;
use Domain\Item\UseCase\DeleteById;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteByIdPresenter implements DeleteByIdPresenterInterface
{
    public function present(DeleteByIdResponse $response): JsonResponse
    {
        $statusCode=500;
        $content=(object)[];
        $content->message = "Erreur inconnue";

        if($response->isStatusSuccess())
        {
            $statusCode = 200;
            $content->message = "Item effacé";
        }
        elseif($response->isStatusNoResult())
        {
            $statusCode = 200;
            $content->message = "L'ID n'est lié à aucun Item";
        }
        elseif($response->isStatusNoDeleted())
        {
            $statusCode = 400;
            $content->message = "L'Item n'a pu être effacé de la base de données";
        }
        $jsonResponse=new JsonResponse();
        $jsonResponse->setStatusCode($statusCode);
        $jsonResponse->setData($content);

        return $jsonResponse;
    }
}