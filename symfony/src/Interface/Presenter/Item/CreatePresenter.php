<?php

namespace Interface\Presenter\Item;

use Domain\Item\Presenter\CreatePresenterInterface;
use Domain\Item\Response\CreateResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreatePresenter implements CreatePresenterInterface
{ 
    public function present(CreateResponse $response): JsonResponse
    {
        $statusCode=500;
        $content=(object)[];
        $content->message = "Erreur inconnue";

        if($response->isStatusSuccess())
        {
            $statusCode = 200;
            $content->message = "Item créé avec succès";
        }
        elseif($response->isStatusMissingFields())
        {
            $statusCode = 400;
            $content->message = "Des champs obligatoires sont manquants";
            $content->fields = $response->getErrors();
        }
        elseif($response->isStatusInvalid())
        {
            $statusCode = 400;
            $content->message = "Des valeurs de champs sont invalides";
            $content->fields = $response->getErrors();
        }
        elseif($response->isStatusExisting())
        {
            $statusCode = 400;
            $content->message = "Un Item avec le même nom existe déjà";
        }

        $jsonResponse=new JsonResponse();
        $jsonResponse->setStatusCode($statusCode);
        $jsonResponse->setData($content);

        return $jsonResponse;
    }
}