<?php

namespace Interface\Presenter\Item;

use Domain\Item\Presenter\UpdatePresenterInterface;
use Domain\Item\Response\UpdateResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class UpdatePresenter implements UpdatePresenterInterface
{
    public function present(UpdateResponse $response): JsonResponse
    {
        $statusCode=500;
        $content=(object)[];
        $content->message = "Erreur inconnue";

        if($response->isStatusSuccess())
        {
            $statusCode = 200;
            $content->message = "Item mis à jours avec succès";
        }
        elseif($response->ifStatusNoFound())
        {
            $statusCode = 400;
            $content->message = "L'ID n'est lié à aucun Item";
        }
        elseif($response->ifStatusNoUniqueName())
        {
            $statusCode = 400;
            $content->message = "Un autre Item possède le même nom";
            $content->name = $response->getItem()->getName();
        }
        elseif($response->ifStatusInvalid())
        {
            $statusCode = 400;
            $content->message = "Des valeurs de champs sont invalides";
            $content->fields = $response->getErrors();
        }

        $jsonResponse=new JsonResponse();
        $jsonResponse->setStatusCode($statusCode);
        $jsonResponse->setData($content);

        return $jsonResponse;
    }
}